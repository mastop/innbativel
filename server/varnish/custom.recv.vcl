# Include the correct Virtual Host configuration file
#if (req.http.Host == "my-wp1.localhost" || req.http.Host == "my-wp2.localhost") {
#    # The Wordpress specific receive
#    include "conf.d/receive/wordpress.vcl";
#} elsif (req.http.Host == "my-forkcms1.localhost" || req.http.Host == "my-forkcms.localhost") {
#    # The ForkCMS specific config
#    include "conf.d/receive/forkcms.vcl";
#} elsif (req.http.Host == "my-drupal1.localhost" || req.http.Host == "my-drupal2.localhost") {
#    # The Drupal 7 specific receive
#    include "conf.d/receive/drupal7.vcl";
#}
