# More code, less spaghetti

This code is part of the Services in Drupal8 workshop developed by [Wizzlern](https://wizzlern.nl) for the [DrupalJam](https://drupaljam.nl) 2017. The Dutch annual Drupal gathering. The slides can be found at [Slideshare](https://www.slideshare.net/ErikStielstra/drupal-jam-2017-services).

Prepare for the workshop by **downloading this code** and **setting-up a Drupal 8 site** with the included starter kit. This package contains all the code you need for the workshop. 

### Directory /starter-kit

Contains Drupal 8 core with configuration, installation profile and custom modules. See below for installation instructions.

### Directory /exercises

Contains step by step exercises that will be executed during the workshop. Exercises are described in exercise.md files and may contain code files that you will copy over to your custom module.

### Directory /final-result

Contains code of the completed exercises. Use it when you get stuck, to learn by reading code or to impress your collegues after the workshop.

## Install Drupal
Create a Drupal site with configuration and content for the workshop.

- Use the code from /starter-kit to setup a Drupal website.
- Use sites/default for settings and files. 
  - Use the provided (modified) sites/default/default.settings.php.
  - The sites/default/settings.local.php will be included by settings.php
- Install Drupal using the Configuration Installer (config_installer) installation profile.
  - Verify in the step 'Upload config' that the Synchronisation directory is: 
    /path/to/drupal-root/profiles/config_installer/config/wizzlern_example
- Check the Status report page and fix any errors.
- Check that the site contains a News content type.
- Check that the site contains News nodes.
