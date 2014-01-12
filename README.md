wordpress-debug-bar-template-trace
==================================

Adds the template trace option to your WordPress debug bar


Origins
==================================

This plugin was originally created by the user ericlewis (http://www.ericandrewlewis.com/) for Wordpress 3.3.1

I've adapted it to work with WordPress 3.5.1, no other code changes have been made.


Things to be aware of
==================================

The way the plugin is created means it injects a hook into your templates.php file (originally theme.php, this has been updated since the 3.3.1 release).
It will automatically look to do this injection if a new version of WP is discovered as well, alternatively you can manually edit this file.

I only changed the file location so that others may use this plugin as it was removed form the Wordpress repository.

As it was removed, I am presuming the original author does not wish to keep maintaining the plugin, I have therefore bumped the version, and replaced the author details with mine so that people who have issues may get in touch regarding it.
If you are the original author and disapprove, please feel free to drop me a line.


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/Clorith/wordpress-debug-bar-template-trace/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

