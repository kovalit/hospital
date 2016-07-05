# Stuff from .capistrano/tasks/submodule_strategy.rb
set :git_strategy, SubmoduleStrategy

# :application is required for some capistrano stuff.
# git-ssh.sh is uploaded to /tmp/#{application}, for example.
set :application, 'hospital.ifilit.com'
set :repo_url, 'git@github.com:kovalit/hospital.git'

# set :branch, ENV["BRANCH"] || "master"

set :scm, :git
set :format, :pretty
set :log_level, :debug
set :pty, true
set :keep_releases, 5

# set :linked_files, %w{protected/config/production.php}
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system protected/runtime}}
set :linked_dirs, %w{protected/runtime public/assets}

# in 3.1 custom namespaces should come before the :deploy
namespace :yii do
	desc 'Yii db migrations.'
	task :migrations do
		on roles(:app) do
				execute "APPLICATION_MODE=#{fetch(:stage)} #{release_path}/protected/yiic migrate --interactive=0"
		end
	end
end

namespace :deploy do
	# after :publishing, 'yii:migrations'
	# after 'yii:migrations', :restart
end
