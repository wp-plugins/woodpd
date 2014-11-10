=== WooDPD ===
Contributors: grendelccl
Tags: woocommerce, dpd, e-commerce, commerce, wordpress ecommerce, store, sales, sell, shop, shopping, cart, buy, widgets
Donate link: http://woodpdplugin.com/
Requires at least: 3.8
Tested up to: 4.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress plugin for WooCommerce and DPD, with cart button widget.

== Description ==

With this plugin for WordPress you can build a shop with WooCommerce, using DPD for the sells. WooDPD replace the "Add to cart" buttons of single products. You can choose also to use a "Buy now" button.

WooDPD also supply a very configurable widget for a "View cart" button. Text of buttons are configurable.

It supplies also the option for a "Read more" button in the "Products" page.

= In the Pro version =

* You can use images for "Add to cart", "Buy now" and "View cart" buttons
* Lightbox functionality

Purchase the Pro version [here](http://woodpdplugin.com/ "WooDPD Plugin").

= Adding a product =

1. Insert a product in the usual way using Products -> Add product in the WordPress admin page.
2. In the product data section enter de "DPD product ID". You can find this identifier in the product list in your DPD account. Save changes.
3. If you want to use the "Buy now" button, you need to also enter the "DPD product price ID". This ID is more difficult to find. In your DPD account go to the "Button/Link Creator", and then go to "Instant Checkout". Choose your product and in the code generated copy the value of "product_price_id". Paste the code in the WordPress product page in the field "DPD product price ID" and save changes.

== Installation ==

= Minimum Requirements =

* WordPress 3.8 or greater
* WooCommerce plugin. Download it [here](http://www.woothemes.com/woocommerce/ "WooCommerce")
* DPD account. You can signup [here](https://getdpd.com/?referrer=jkk7lxus5dkwks "DPD: Digital Product Delivery")

= Manual installation =

1. Upload the entire 'woodpd' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. In the WordPress admin page go to WooCommerce -> Settings.
4. Enter your DPD cart ID in "DPD Cart URL". Save changes.
5. In the "Checkout" tab, clear the option of "Cart Page" and "Checkout Page". Also remove all cart or checkout menus and widgets if they exist from your blog.

== Frequently Asked Questions ==

= Where are the settings of the plugin? =

The settings of the plugin will appear inside the WooCommerce settings page, in the WordPress admin page, of course. The WooDPD Plugin configuration will be in the General Options section.

= Why there is a DPD product price ID field? =

That value is necessary only for the instant purchase feature ("Buy now" buttons). To find this value log into your DPD account, go to the "Button/Link Creator", and then go to "Instant Checkout". Choose your product and in the code generated copy the value of "product_price_id" to paste in the DPD product price ID field.

== Screenshots ==

1. Admin options
2. Product options

== Changelog ==

= 1.0.0 =
* Initial Release
