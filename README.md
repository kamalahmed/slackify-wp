# Slackify WP
This is a very simple and lightweight plugin for connecting your WordPress site to your slack. You can receive new woocommerce order notification directly to your slack.
This plugin can be extended easily for any notification purpose from your WordPress site to your slack.
I have added two examples in the plugin.
Currently the plugin does the following. However, I will enhance the plugin later. You can create an issue for any feature request.
- It sends a notification when a new order is placed on your WooCommerce site.
- It sends a notification when a new question is asked in your support forum created using DW question answer plugin.
- It sends a notification when a new answer is posted in your support forum created using DW question answer plugin.

## How to use it?
- Download the plugin and upload the zip to your WordPress site.
- Install and activate it.
- Go to `https://api.slack.com/` and create an app and give it any name you like and give the app access to your favourite workspace during the creation.
- from the app dashbaord, create `an incoming webhook` url and copy that url.
- open your wp-config.php file and define a constant with name `SLACK_WEBHOOK_URL` and set your slack incoming webhook url as its value.
- For Example: `define('SLACK_WEBHOOK_URL', 'https://hooks.slack.com/services/YOUR_WEBHOOK_URL');` and add this just before this line `/* That's all, stop editing! Happy publishing. */` in `wp-config.php`.
- Now create a question and test the integration. You should get a message on your slack as soon as a question is published. You can also create a order to test it.


  In the future version, I will add an UI for setting the webhook url as well as for testing the integration with a click on a button. 


### This plugin is free for use. If you like it, then inspire me by giving this repository a star. Thank you!
  
