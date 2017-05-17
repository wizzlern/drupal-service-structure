# More code, less spaghetti

This code is part of a workshop developed by [Wizzlern](https://wizzlern.nl) specially for the [DrupalJam](https://drupaljam.nl) 2107. The Dutch annual Drupal gathering.

This contains all the code you need for the workshop. 
Prepare for the workshop by **downloading this code and setting-up a Drupal 8 site with the starter kit**.

## Directory /starter-kit

Contains Drupal 8 core with configuration, installation profile and custom modules. See below for installation instructions.

## Directory /exercises

Contains step by step exercises that will be executed during the workshop. Exercises are described in exercise.md and may contain code files that you will copy over to your custom modules.

## Directory /final-result

Contains code of the completed exercises. Use it when you get stuck, to learn by reading code or to impress your collegues after the workshop.

## Install Drupal
Create a Drupal site with configuration and content for the workshop.

- Use the code from /starter-kit to setup a Drupal website.
- Use sites/default for settings and files. 
  - Use the provided (modified) sites/default/default.settings.php.
  - The provided sites/default/settings.local.php will be included by settings.php
  - Note that sites/default/files/config_* is already included in the repository. This is used by the config_installer profile.
- Install Drupal using the Configuration Installer installation profile.
- Check the Status report page (/admin/reports/status) and fix any errors.
- Check that the site now contains a News content type.
- Import content by enabling the Wizzlern Example Content module (we_content).
- Check that the site now contains News nodes.
