#Deployment guides

- ######REQUIREMENT

	```
	1. Install Git Bash (https://git-scm.com/downloads) or MSYS2 (https://www.msys2.org/)
	2. Uninstall default Python & install Python 2.7.15 (https://www.python.org/downloads/release/python-2715/) then add to system path
	3. Install Fabric 1.14.0 (pip install fabric==1.14.0)
	4. Uninstall default Paramiko (pip uninstall paramiko) and install Paramiko 2.6.0 (pip install paramiko==2.6.0)
	5. Get Rsync (from teammate) and add to system path
	```

- ######Deploy staging ROOT

	```
	npm run deploy-staging-root
	```

- ######Deploy staging THEME

	```
	npm run deploy-staging
	```

- ######Deploy production ROOT

	```
	npm run deploy-prod-root
	```

- ######Deploy production THEME

	```
	npm run deploy-prod
	```
