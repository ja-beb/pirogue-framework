# A PHP Micro Framework
An adaptation of a small framework which I originally created for projects in 2007. Designed to provide a foundation that was simplified web projects by making them easy to learn, deploy, and update. Was used at a prior employer to enable junior staff with little to no training in web development the ability to quickly produce working web-based applications. 
I would not recommend the usage of this beyond "quick and dirty" prototypes or learning. This does not support many of the features required in a modern enterprise application. This is more an exercise in how frameworks work and how structured structured could be used to create a MVC web framework. It is also a used to test newer features in php 8.x (original framework was written in php 4/5). 
## Project Conventions
- PSR-12: Extended Coding Style (https://www.php-fig.org/psr/psr-12/)
### File Extensions
+ .php = php executable or include file.
+ .phtml = php template file - contains both html and php content.
### General Rules
- snake case for functions and variables.
- kebab case for path components, array labels, and form input labels (example: site-users/user-assignment.json).
### Functions
- pirogue\ibrary\_init() = library initialize function.
- pirogue\_library\_dispose() = internal function, library destructor function registered when library is initialized.
- pirogue\library\name_func() = public function within a library (ie dispatcher_route()).
- pirogue\library\_name_func() = internal function, used within dispatcher and library only. 
### Global Variables
Variables registered with a global array ($GLOBALS or $_SESSION) are prefixed with the '.' character to prevent them from being exported to the current symbol table or being made available with the "register globals" (prevent user from impulating register_globals).
- $GLOBALS['.\_pirogue.library-name'] = internal variable (prefixed with '.\_').
- $GLOBALS['.pirogue.library-name'] = public variable (prefixed with '.').
### Local Variables
- $\_varaible_name =  interal variable that is scoped to current scope only.
- $varaible_name = public variable - can be used outside of scope.
### Path 
Any parts of a path that are prefixed with a '_' character are considered "protected" and are not directly accessabile to the client (can not be routed by HTTP requests). The dispatcher is repsonsible for removing these special character prefixes. They can be accessed via internal calls only. 
- public/public.phtml = public file.
- _private/end-point.phtml = internal file.
- public/_private.phtml = internal file.
## Controllers
Controllers are loaded from a seperate folder and should implement the following interface. within their own namespace.
- "{$controller name}\_init"
- "{$controller name}\_dispose" 
- "{$controller name}\has_access"
- "{$controller name}\_error_403" - optional, intercepts and handles HTTP 403 errors form default controller.
- "{$controller name}\_error_404" - optional, intercepts and handles HTTP 404 errors form default controller.
- "{$controller name}\_error_405" - optional, intercepts and handles HTTP 405 errors form default controller.
- "{$controller name}\_error_500" - optional, intercepts and handles HTTP 500 errors form default controller.
- "{$controller name}\{$action}_{$request method}" - action invoked in controller. For example, if the user requests account/index.html then this request would mapp to the function account_index_get().
## Views
Views are stored in a seperate folder and are loaded by the controller's action function.
## Example project layout
The following defines the directory structure for a trival example site that allows users to log in, view account information and update their information.
```
/include
  -- pirogue/
  -- website/
/config
  -- mysqli-website.ini
/controller
  -- _default.php
  -- account.php
  -- session.php
/htdocs
  -- css/
  -- script/
  -- fonts/
  -- _dispatcher.php
/view
  -- _page.phtml
  -- account-index.phtml
  -- account-update-password.phtml
  -- account-update-info.phtml
  -- index.phtml
  -- login-form.phtml

```
