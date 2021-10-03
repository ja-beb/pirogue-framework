# A PHP Micro Framework

Adaptation of the a small framework that was originally used for projects from 2005-2013. Designed to provide a easy to learn, deploy and update foundation for projects. Used to allow staff with little to no formal training the ability to quickly produce working web applications. 

I would not recommend the usage of this beyond "quick and dirty" prototypes or learning. This does not support many of the features required in a modern enterprise application. This is more an exercise in how frameworks work and how an imperitive design could be used with the features of php 8.x (original framework was written in php 4/5). This is also an experiment to see how non-MVC design paradigm peforms compared to a more traditional MVC designs.

## Project uses the following conventions:
- PSR-12: Extended Coding Style (https://www.php-fig.org/psr/psr-12/)
- file extensions:
	+ .php = php executable or include file.
	+ .phtml = php template file - contains both html and php content.
- snake case for functions and variables.
- kebab case for path components (example: site-users/user-assignment.json).

## Naming conventions
### Functions
- pirogue_library_init() = library setup/initialize function
- pirogue_library_destruct() = library destructor function
- pirogue_library_name_func() = public function within a library (ie dispatcher_route()).
- _pirogue_library_name_func() = internal function, used within dispatcher and library only. 

### Global Variables
- $GLOBALS['.\_pirogue.library.name'] = internal variable (prefixed with '.\_').
- $GLOBALS['.pirogue.library.name'] = public variable (prefixed with '.')

### Local Variables
- $\_varaible_name =  variable is scoped to current code block (file or function depending on scope). 
- $varaible_name = public variable, visible outside of scope. Avoid using between files - use a registered global instead (see "Global Variables" section).

### Path 
Any parts of a path that are prefixed with a '_' character are considered "protected" and are not directly accessabile to the client (can not be routed by HTTP requests). The dispatcher is repsonsible for removing these special character prefixes. They can be accessed via internal calls only. 
- _private/end-point.phtml = private path component.
- public/_private.phtml = private file.


