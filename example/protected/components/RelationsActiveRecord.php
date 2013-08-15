<?php

/**
 * The BasicRelationsModel class implements some helper methods that will be
 * needed by several of the children classes.
 */
class RelationsActiveRecord extends CActiveRecord {
	// Used to cache the computed values of the magic attributes.
	protected $_magic_attributes=array();

	// A list of AR's that are eligible for deletion. Updated with the
	// magicRelation*Write methods. It is used when calling save() to delete
	// unused related AR records.
	protected $_eligible_for_delete=array();

	// Track a list of relations that were updated with the
	// magicRelation*Write methods. Used to cascade the save() operations only
	// to objects that have actually changed.
	protected $_relation_updated=array();

	// Issued in the afterSave() behavior. Must contain arrays with the following format:
	// array (
	//   'table' => string,
	//   'conditions' => mixed,
	//   'params' => array (),
	// ),
	// table - The table that new rows will be inserted into.
	// conditions - the conditions that will be put in the WHERE part.
	// params - the parameters to be bound to the query.
	protected $_delete_commands=array ();

	// Issued in the afterSave() behavior. Must contain arrays with the following format:
	// array (
	//   'table' => string,
	//   'columns' => array (),
	// ),
	// table - The table that new rows will be inserted into.
	// columns - The column data (name=>value) to be inserted into the table.
	protected $_insert_commands=array ();

	// Emulate cascade on delete if the DB does not support it.
	protected $cascade_on_delete=false;

	/**
	 * Used for mapping the many to many relations with a pivot class and/or a
	 * attribute. The class will be used to merge the changes instead of just
	 * deleting all existing entries and recreating them. The attribute will
	 * be used for the magic attribute post_attributes to map the array of
	 * ID's from a form so in order to use the post_attributes the 'attribute'
	 * must be specified. If you do not want to use the merging the class name
	 * can be left out.
	 * 
	 * Entries in this array must be in the following format:
	 * '<relation name>' => array (
	 *   'class' => '<pivot class name>',
	 *   'attribute' => '<attribute name>'
	 * ),
	 */
	public function many_many_map () {
		return array();
	}

	/**
	 * Runs a SQL statement to determine if the AR id specified exists in the
	 * table for this class. Lighter than findByPk cause a new object is not
	 * instantiated.
	 * TODO: Implement support for composite primary keys.
	 */
	public function idPresent ($check_for_id) {
		if (empty ($check_for_id))
			return false;
		$primary_key=$this->tableSchema->primaryKey;
		if (Yii::app()->db->createCommand()
			->select($primary_key)
			->from($this->tableName())
			->where($primary_key.'=:id', array (':id'=>$check_for_id))
			->queryRow() )
			return true;
		return false;
	}

	/**
	 * Overload the refresh() method so the magic attributes cache can be
	 * cleared.
	 */
	public function refresh () {
		$this->_magic_attributes=array();
		return parent::refresh();
	}

	public function expandCallables($array) {
		foreach ($array as $key => $entry) {
			if (is_callable ($entry))
				$array[$key]=call_user_func ($entry);
			if (is_array ($entry))
				$array[$key]=$this->expandCallables ($entry);
		}
		return $array;
	}

	/************************************************************************/

	/**
	 * Marks a object a eligible for delete. Checks to see if the object is
	 * already in the list of objects to be updated and removes it.
	 */
	public function magicRelationEligibleForDelete ($relation_name, $relation_object) {
		$relations=$this->relations();
		$relation_primary_key=$relation_object->tableSchema->primaryKey;
		// TODO: add support for composite primary keys.
		$pk=$relation_object->$relation_primary_key;
		if (isset ($this->_relation_updated[$relation_name][$pk]))
			unset ($this->_relation_updated[$relation_name][$pk]);
		$this->_eligible_for_delete[]=$relation_object;
	}

	/**
	 * Mark a object as changed, and trigger a save() when the main object is
	 * saved(). (Cascade Save). If the object's attributes are empty it marks
	 * it as eligible for delete.
	 */
	public function magicRelationUpdated ($relation_name, $relation_object) {
		// first check to see if the object's attributes are empty.
		$relations=$this->relations();
		$relation_settings=$relations[$relation_name];
		$relation_primary_key=$relation_object->tableSchema->primaryKey;
		$attributes=$relation_object->attributes;
		// TODO: add support for composite primary keys.
		unset ($attributes[$relation_primary_key]);
		// TODO: add support for composite foreign keys.
		unset ($attributes[$relation_settings[2]]);
		if (empty ($attributes)) {
			// eligible for delete.
			$this->magicRelationEligibleForDelete ($relation_name, $relation_object);
			return;
		}
		// tag for update.
		if (!isset ($this->_relation_updated[$relation_name]))
			$this->_relation_updated[$relation_name]=array ('new' => array());
		if ($relation_object->isNewRecord) {
			$this->_relation_updated[$relation_name]['new'][]=$relation_object;
		} else {
			$pk=$relation_object->$relation_primary_key;
			$this->_relation_updated[$relation_name][$pk]=$relation_object;
		}
	}

	/**
	 * A magic setter used for processing the $_POST variable for this class
	 * and all the related classes.
	 */
	public function setPost_Attributes($POST) {
		if (!isset ($POST[get_class ($this)]))
			return;
		$this->attributes=$POST[get_class ($this)];
		foreach ($this->relations() as $relation_name => $relation_settings) {
			$relation_type=$relation_settings[0];
			$relation_class=$relation_settings[1];
			$relation_fk=$relation_settings[2];
			switch ($relation_type) {

				case 'CHasOneRelation':
					if ($this->isNewRecord || empty ($this->$relation_name)) {
						if (!isset ($POST[$relation_class]))
							continue;
						// Has One is new or not attached.
						$this->$relation_name=new $relation_class;
					} elseif (!isset ($POST[$relation_class])) {
						$this->$relation_name->unsetAttributes();
						$this->magicRelationUpdated ($relation_name, $this->$relation_name);
						$this->$relation_name=null;
						continue;
					}
					$this->$relation_name->attributes=$POST[$relation_class];
					$this->magicRelationUpdated ($relation_name, $this->$relation_name);
					break;

				case 'CHasManyRelation':
					if ($this->isNewRecord || empty ($this->$relation_name)) {
						if (!isset ($POST[$relation_class]))
							continue;
						// Has Many is new or none are attached.
						$model_list=array ();
						foreach ($POST[$relation_class] as $post_attributes) {
							$model=new $relation_class;
							$model->attributes=$post_attributes;
							$this->magicRelationUpdated ($relation_name, $model);
							$model_list[]=$model;
						}
						$this->$relation_name=$model_list;
					} else {
						$model_list=array ();
						$delete_models=$this->$relation_name;
						// Has Many is present and needs to be merged with the incomming data.
						$relation_pk=$relation_class::model()->tableSchema->primaryKey;
						if (!empty ($POST[$relation_class])) {
							$post_attribute_list=$POST[$relation_class];
							foreach ($delete_models as $delete_models_key => $model) {
								foreach ($post_attribute_list as $post_attributes_key => $post_attributes) {
									// Check to see if any of the incoming entries match the PK of the current entry.
									if (isset ($post_attributes[$relation_pk]) &&
									    $post_attributes[$relation_pk] === $model->$relation_pk) {
										// Match found.
										$model->attributes=$post_attributes;
										$this->magicRelationUpdated ($relation_name, $model);
										$model_list[]=$model;
										// Pop the model off the delete list and off the incoming entries
										unset ($delete_models[$delete_models_key]);
										unset ($post_attribute_list[$post_attributes_key]);
										continue 2;
									}
								}
							}
							// Matching complete.
							// Create remaining new models.
							if (!empty ($post_attribute_list)) {
								foreach ($post_attribute_list as $post_attributes) {
									$model=new $relation_class;
									$model->attributes=$post_attributes;
									$this->magicRelationUpdated ($relation_name, $model);
									$model_list[]=$model;
								}
							}
							$this->$relation_name=$model_list;
// This behavior may not be desirable
//						} else {
//							$delete_models=$this->$relation_name;
//							$this->$relation_name=array ();
						}
						// Delete left over models.
						if (!empty ($delete_models)) {
							foreach ($delete_models as $model) {
								$this->magicRelationEligibleForDelete ($relation_name, $model);
							}
						}
					}
					break;

				case 'CManyManyRelation':
					$many_many_map=$this->many_many_map();
					// If the mapping is not setup correctly ignore this relation
					// because there is no way to identify the incoming data.
					if (empty ($many_many_map[$relation_name]) ||
					    empty ($many_many_map[$relation_name]['attribute']))
						continue;
					$delete_ids=array ();
					$insert_ids=array ();
					$relation_pk=$relation_class::model()->tableSchema->primaryKey;
					$list_attribute=$many_many_map[$relation_name]['attribute'];
					// Retrieve the new list of ID's
					$selection=$this->$list_attribute;
					// Determine the current attached ID's
					if (!empty ($this->$relation_name)) {
						foreach ($this->$relation_name as $related_model) {
							if (in_array ($related_model->$relation_pk, $selection))
								unset ($selection[array_search ($related_model->$relation_pk, $selection)]);
							else
								$delete_ids[]=$related_model->$relation_pk;
						}
						$insert_ids=$selection;
					} else {
						$insert_ids=$selection;
					}
					$pivot_table=$this->metaData->relations[$relation_name]->getJunctionTableName();
					$foreign_keys=$this->metaData->relations[$relation_name]->getJunctionForeignKeys();
					$relation_key_column=array_shift ($foreign_keys);
					$remote_key_column=array_shift ($foreign_keys);
					$primary_key=$this->tableSchema->primaryKey;
					// Build insert commands
					if (!empty ($insert_ids)) {
						$this_var=$this;
						foreach ($insert_ids as $id) {
							$this->_insert_commands[]=array (
								'table' => $this->metaData->relations[$relation_name]->getJunctionTableName(),
								'columns' => array (
									$relation_key_column => function () use ($this_var, $primary_key) { return $this->$primary_key; },
									$remote_key_column => $id,
								),
							);
						}
					}
					// Build delete commands.
					if (!empty ($delete_ids)) {
						foreach ($delete_ids as $id) {
							$this->_delete_commands[]=array (
								'table' => $this->metaData->relations[$relation_name]->getJunctionTableName(),
								'conditions' => array (
									'and',
									$relation_key_column.' = :this_id',
									$remote_key_column.' = :remote_id',
								),
								'params' => array (
									':this_id' => $this->$primary_key,
									':remote_id' => $id,
								),
							);
						}
					}
					break;
			}
		}
	}

	/************************************************************************/

	public function magicRelationManyManySelectedRead ($relation_name) {
		if (isset ($this->_magic_attributes[$relation_name.'_selected']))
			return $this->_magic_attributes[$relation_name.'_selected'];
		if (empty ($this->$relation_name))
			return null;
		$relations=$this->relations();
		$relation_settings=$relations[$relation_name];
		$primary_key=$relation_settings[1]::model()->tableSchema->primaryKey;
		$selected_list=array ();
		foreach ($this->$relation_name as $model)
			$selected_list[]=$model->$primary_key;
		return $this->_magic_attributes[$relation_name.'_selected']=$selected_list;
	}

	public function magicRelationManyManySelectedWrite ($relation_name, $selected_list) {
		$this->_magic_attributes[$relation_name.'_selected']=$selected_list;
	}

	/************************************************************************/

	public function getAllErrors () {
		$errors=$this->getErrors();
		$relations=$this->relations();
		if (empty ($relations))
			return $errors;
		foreach ($relations as $relation_name => $relation_settings) {
			if (empty ($this->$relation_name))
				continue;
			if (is_object ($this->$relation_name)) {
				if (!empty ($this->$relation_name->errors))
					$errors[$relation_name]=$this->$relation_name->getErrors ();
			} elseif (is_array ($this->$relation_name)) {
				$errors[$relation_name]=array ();
				foreach ($this->$relation_name as $related_key => $related_model) {
					if (!empty ($related_model->errors))
						$errors[$relation_name][$related_key]=$related_model->getErrors ();
				}
				if (empty ($errors[$relation_name]))
					unset ($errors[$relation_name]);
			}
		}
		return $errors;
	}

	/************************************************************************/

	/**
	 * If any models have been updated, itterate over them and issue the
	 * validate() method. Assign any errors to their relation name.
	 */
	public function beforeValidate() {
		if (empty ($this->_relation_updated))
			return parent::beforeValidate();
		$primary_key=$this->tableSchema->primaryKey;
		$relations=$this->relations();
		$isValid=true;
		foreach ($this->_relation_updated as $relation_name => $related_models) {
			if (empty ($related_models))
				continue;
			$relation_settings=$relations[$relation_name];
			if (!empty ($related_models['new'])) {
				foreach ($related_models['new'] as $new_models)
					$related_models[]=$new_models;
			}
			unset ($related_models['new']);
			foreach ($related_models as $key => $model) {
				$isValid=$isValid & $model->validate();
				if ($model->hasErrors()) {
					// Validation failed, bubble the errors up.
					foreach ($model->errors as $attribute => $error_messages)
						// Map the related model errors onto the related attribute.
						foreach ($error_messages as $message)
							$this->addError ($relation_name, $message);
				}
			}
		}
		return $isValid & parent::beforeValidate();
	}

	/**
	 * Start a DB transaction and cleans up all the objects that are eligible
	 * for delete.
	 */
	public function beforeSave () {
		// Start a transaction
		// Issue the delete() on all eligible objects.
		if (!empty ($this->_eligible_for_delete)) {
			foreach ($this->_eligible_for_delete as $related_object) {
				$related_object->delete();
			}
			$this->_eligible_for_delete=array ();
		}
		return parent::beforeSave();
	}

	/**
	 * Cascaed the save() to all related objects that changed and commit the
	 * transaction.
	 */
	protected function afterSave () {
		// Issue delete commands
		if (!empty ($this->_delete_commands)) {
			foreach ($this->_delete_commands as $delete_command) {
				$delete_command=$this->expandCallables ($delete_command);
				Yii::app()->db->createCommand()->delete (
					$delete_command['table'],
					$delete_command['conditions'],
					$delete_command['params']
				);
			}
		}
		// Issue insert commands
		if (!empty ($this->_insert_commands)) {
			foreach ($this->_insert_commands as $insert_command) {
				$insert_command=$this->expandCallables ($insert_command);
				Yii::app()->db->createCommand()->insert (
					$insert_command['table'],
					$insert_command['columns']
				);
			}
		}
		// Issue the save() on all changed objects.
		if (!empty ($this->_relation_updated)) {
			$primary_key=$this->tableSchema->primaryKey;
			$relations=$this->relations();
			foreach ($this->_relation_updated as $relation_name => $related_models) {
				if (empty ($related_models))
					continue;
				$relation_settings=$relations[$relation_name];
				// models are seperated into 2 groups, new object and models that
				// already existed in the db, but were changed.
				foreach ($related_models as $pk_or_new => $r_model) {
					if ($pk_or_new === 'new') {
						foreach ($r_model as $new_model) {
							if (empty($new_model->$relation_settings[2]))
								$new_model->$relation_settings[2]=$this->$primary_key;
							$new_model->save();
						}
						continue;
					}
					$r_model->save();
				}
			}
			$this->_relation_updated=array ();
		}
		// end transaction/commit.
		return parent::afterSave();
	}

	public function cascade ($cascade_setting) {
		$this->cascade_on_delete=$cascade_setting;
	}

	/**
	 * Emulates the cascade delete if the cascade variable is set to true.
	 */
	protected function beforeDelete () {
		if (!$this->cascade_on_delete)
			return parent::beforeDelete();
		// start transation.
		// Itterate through the relations, issue deletes for Has One, Has
		// Manies, and the pivot table for the Many Manies.
		foreach ($this->relations () as $relation_name => $relation_settings) {
			if (empty ($this->$relation_name))
				continue;
			switch ($relation_settings[0]) {
				case 'CHasOneRelation':
					$this->$relation_name->delete();
					break;
				case 'CHasManyRelation':
					foreach ($this->$relation_name as $relation_entry)
						$relation_entry->delete();
					break;
				case 'CManyManyRelation':
					$primary_key=$this->tableSchema->primaryKey;
					$pivot_table=$this->metaData->relations[$relation_name]->getJunctionTableName();
					$foreign_keys=$this->metaData->relations[$relation_name]->getJunctionForeignKeys();
					$primary_key_column=array_shift ($foreign_keys);
					$conditions="$primary_key_column = :id";
					$params=array (':id' => $this->$primary_key);
					$rows_affected=Yii::app()->db->createCommand()->delete ($pivot_table, $conditions, $params);
					break;
				default:
					continue;
			}
		}
		return parent::beforeDelete();
	}

	public function afterDelete () {
		// end transaction
		return parent::afterDelete();
	}

}
