Help Center was developed by Pirata Nervo.
Copyright: � 2009-2010 Pirata Nervo
Website: http://www.consoleworld.net
Website: http://mybb-plugins.com

License: license.txt


* Updated to 1.8 for MyBB 1.8.x 

by:  Vintagedaddyo: http://community.mybb.com/user-6029.html

- minor changes to add category id display to ticket open/close listing as per user request here: https://community.mybb.com/thread-221511.html

* Updated to 1.7 for MyBB 1.8.x 

by:  Vintagedaddyo: http://community.mybb.com/user-6029.html

- Fixed issues where in the previous version it could only be installed by disabling MySQL strict mode

- Minor changes to the frontend to improve user navigation 

* further localization support

- english
- englishgb
- espanol
- french
- italiano



* Updated to 1.6 for MyBB 1.8.x 

by:  Vintagedaddyo: http://community.mybb.com/user-6029.html


- Currently can only currently be installed by disabling MySQL strict mode

----- Description

Help Center is a powerful help center plugin for MyBB.

Management/Support team can:
# Browse opened and closed tickets
# View tickets
# Close tickets
# Open tickets
# View the support team (shows the list of groups that are managers)
# Create/Edit help documents
# View help documents documents

Those with access to the admin panel can:
# Create priorities
# Create help categories
# Create ticket categories
# Change the settings if I want to disable or enable something

Regular users can:
# Browse opened and closed tickets
# View my opened and closed tickets
# Reply to my own tickets
# be PM'd when someone replies to my ticket
# View help documents

It is NOT possible to MASS delete tickets, you must do it one by one.
You must add a link to helpcenter.php yourself!

----- Installation Instructions
Upload contents of the Upload folder to the root of your MyBB installation.
Go to Admin CP -> Configuration -> Plugins and Activate "Help Center"
Then go to Settings -> Help Center and change anything you need.

----- Upgrading Instructions (1.4 -> 1.5)
Upload contents of the Upload folder to the root of your MyBB installation, overwritting the existing content.
Now, deactivate Help Center (do not click Uninstall!) and then activate it again.
Done!

----- Upgrading Instructions (1.3 -> 1.4)
Upload the upgrade file to the root fo your MyBB installation and run it.
Delete the upgrade file from your server.
Upload contents of the Upload folder to the root of your MyBB installation, overwritting the existing content.
Done!

------ Change Log
 * 1.8 by: Vintagedaddyo
Minor changes to add cid display to ticket listing.

 * 1.7 by: Vintagedaddyo
Fixed a few minor issues.
Updated version to work with later 1.8.x

 * 1.6 by: Vintagedaddyo
Fixed a few minor issues.
Updated version to work with 1.8.x
Added Menu Manager Help Center Edition to add Menu Item in Forum Toplinks

 * 1.5
Fixed a few minor issues.
Fixed two pagination bugs.
Fixed a bug in deleting tickets (would not subtract one from the category tickets counter)
Added bread crumbs.
Fixed 3 possible CSRF vulnerabilities.
Now all templates are cached.
Changed license to GPLv3.
Compatible with MyBB 1.6 only.

 * 1.4
Added edit documents feature.
Emails are not set to HTML so you can view tickets properly formatted from your email account.
Shows list of members that belong to managers groups in the support team page.
Added a few minor features that you probably won't notice.
Fixed a few minor issues.

 * 1.3
Fixed a typo.
Fixed a bug that would display an error after deleting a document.

 * 1.2
Fixed an error that would show up when creating a new help document.

 * 1.1
Fixed a problem in view ticket
Fixed an email formatting bug.
Fixed a bug in close and open ticket links
Added online location
Managers can now delete tickets