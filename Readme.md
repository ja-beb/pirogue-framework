# A PHP Micro Framework

## Project uses the following conventions:
- 0TB - linux kernel variant (standard PHP).
- file extensions: 
	+ .inc = php include file.
	+ .php = php executable.
	+ .phtml = php template file - contains html and php content.
- snake case for functions and variables.
- kebab case for path components (example: site-users/user-assignment.json).

## Naming conventions
### Functions
- __library_name() = library setup function
- _function_name() = internal function
	+ This should only be used by library (exception being the main dispatchers since they are considered part of the main library).
- function_name() = public function	

### Global Variables
- $GLOBALS['.\_namespace[::namespace].library.name'] = internal variable (prefixed with '.\_').
- $GLOBALS['.namespace[::namespace].library.name'] = public variable (prefixed with '.')

### Local Variables
- $\_varaible_name = internal variable (prefixed with '\_').
- $varaible_name = public variable.

### Path 
Any parts of a path that are prefixed with a '_' character are considered "protected" - meaning the client can not be routed directly to them by requesting them. The dispatcher is repsonsible for removing these special character prefixes. They can be accessed via internal calls though.
- _private/end-point.json = private path component.
- public/_private.json = private path compenent internal.

