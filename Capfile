#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
load 'deploy'
load 'config/deploy'

after "deploy:setup", "deploy:unbreak_ssh"

after "deploy:finalize_update", "deploy:cleanup_runtime"
after "deploy:cleanup_runtime", "deploy:migrate_test_db"
after "deploy:migrate_test_db", "deploy:run_unit_tests"
after "deploy:run_unit_tests", "deploy:migrate_db"

namespace :deploy do
	desc "Corrects the asset and runtime folder permissions."
	task :cleanup_runtime do
		asset_folder="#{release_path}/example/assets"
		runtime_folder="#{release_path}/example/protected/runtime"
		run "mkdir -p #{asset_folder}" unless File.exists?(asset_folder)
		run "chmod 775 -R #{asset_folder}"
		run "mkdir -p #{runtime_folder}" unless File.exists?(runtime_folder)
		run "chmod 775 -R #{runtime_folder}"
	end

	desc "Runs the unit tests after deployment."
	task :run_unit_tests do
		run "if [ -e #{release_path} ]; then
			cd #{release_path}/example/protected/tests;
		else
			cd #{current_release}/example/protected/tests;
		fi && phpunit ./unit/"
	end

	desc "Runs the unit tests after deployment."
	task :run_unit_tests_with_coverage do
		run "if [ -e #{release_path} ]; then
			cd #{release_path}/example/protected/tests;
			mkdir -p #{release_path}/example/reports/;
		else
			cd #{current_release}/example/protected/tests;
			mkdir -p #{current_release}/example/reports/;
		fi && phpunit --coverage-html ../../reports/ ./unit/"
	end

	desc "Ensures that the app user can log in using ssh keys after running deploy:setup"
	task :unbreak_ssh do
		run "chmod 755 #{deploy_to}"
	end

	desc "Applies the migrations to the test db"
	task :migrate_test_db do
		run "cd #{release_path}/example/protected && ./yiic migrate --interactive=0 --connectionID=testDb"
	end

	desc "Applies the migrations to the production db"
	task :migrate_db do
		run "cd #{release_path}/example/protected && ./yiic migrate --interactive=0"
	end
end
