load 'deploy'
load 'config/deploy'

after "deploy:setup", "deploy:unbreak_ssh"

after "deploy:finalize_update", "deploy:cleanup_runtime"
after "deploy:cleanup_runtime", "deploy:run_unit_tests"

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

	desc "Ensures that the app user can log in using ssh keys after running deploy:setup"
	task :unbreak_ssh do
		run "chmod 744 #{deploy_to}"
	end
end
