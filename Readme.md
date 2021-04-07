# A PHP Micro Framework

Adaptation of the a small framework that was originally used for projects from 2005-2013. Designed to provide a easy to learn, deploy and update site foundation for projects. Used to allow staff with little to no formal training to quickly produce web applications. Framework was also used to develop, deploy and refine web based applications and reports in realtime during an emergency event (Hurricane Isaac 2012).

I would not recommend the usage of this beyond "quick and dirty" prototypes or learning. This does not support many of the features required in a modern enterprise application. This is more an exercise in how frameworks work and how an imperitive design could be used with the features of php 7.x (original framework was written in php 4/5). It is also an experiment in a non-MVC design paradign.

## Project uses the following conventions:
- 1TBS - linux kernel variant (standard PHP).
- file extensions: 
	+ .inc = php include file.
	+ .php = php executable.
	+ .phtml = php template file - contains html and php content.
- snake case for functions and variables.
- kebab case for path components (example: site-users/user-assignment.json).

## Naming conventions
### Functions
- __library() = library setup/initialize function
- library_name() = public function within a library (ie dispatcher_route()).
- _library_name() = "protected" internal function, used within dispatcher and library only. 
- __library_name() = "private" library function, do not call outside of library file.

### Local Variables
- $\_varaible_name =  variable is scoped to current code block (file or function depending on scope). 
- $varaible_name = public variable, visible outside of scope. Avoid using between files - use a registered global instead (see "Global Variables" section).

### Global Variables
- $GLOBALS['.\_namespace[::namespace].library.name'] = internal variable (prefixed with '.\_').
- $GLOBALS['.namespace[::namespace].library.name'] = public variable (prefixed with '.')

### Path 
Any parts of a path that are prefixed with a '_' character are considered "protected" - meaning the client can not be routed directly to them by requesting them. The dispatcher is repsonsible for removing these special character prefixes. They can be accessed via internal calls though.
- _private/end-point.json = private path component.
- public/_private.json = private path compenent internal.


## Configuring Docker Environment
The docker environment uses a nginx LAMP stack. This requires a self signed certificate to run localally and can be generated using the following commands.

`
$ openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ./docker/ssl/private/nginx-selfsigned.key -out ./docker/ssl/certs/nginx-selfsigned.crt
$ openssl dhparam -out ./docker/ssl/certs/dhparam.pem 2048
`
The current enviroment uses two URLS that will have to be entered into your systems host file (/etc/hosts). Once added open these locations using the browser of choice and accept the certificates.
- https://pirogue-testing.local
- https://cdn.pirogue-testing.local


### /etc/hosts
`
127.0.0.1 pirogue-testing.local
::1 pirogue-testing.local

127.0.0.1 cdn.pirogue-testing.local
::1 cdn.pirogue-testing.local
`




