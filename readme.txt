=== My Account Customizer for WooCommerce ===
Contributors: algoritmika, thankstoit, anbinder, karzin
Tags: woocommerce, my account, woo commerce
Requires at least: 4.4
Tested up to: 6.8
Stable tag: 2.0.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Customize the "My account" page. Beautifully.

== Description ==

**My Account Customizer for WooCommerce** plugin lets you customize the "My account" page.

### 🚀 Add Extra Fields & Tabs to WooCommerce User Accounts ###

Enhance your WooCommerce "My Account" section with the "My Account Customizer" plugin, offering diverse field types, additional tabs, multilingual support, and dynamic content for a personalized user dashboard experience.

### 🚀 Add New Fields in My Account Page ###

Enhance the "Account details" tab and user profile page by adding new, custom fields.

Select from multiple field types, including Color, Date, Email, Month, Number, Password, Range, Tel, Text, Time, URL, Week, Gravatar (Profile Picture), and Title.

These diverse options enable a rich customization of the user profile, facilitating the collection of a wide range of customer information and enhancing the personalization of their shopping experience on your WooCommerce store.

### 🚀 Create Additional Tabs in My Account Dashboard ###

Create extra tabs in the "My Account" section, offering an organized way to display varied content like user-specific data or custom interactions.

This extra tab can enhance the user dashboard with more functionality, allowing your users to find their information easier.

### 🚀 Dynamic Content with Shortcodes and Advanced Customization ###

Combine the power of shortcodes and advanced customization options for enhancing the "My Account" dashboard.

Utilize shortcodes like `[alg_wc_mac_user_comments]` for dynamic content displays and integrate "Font Awesome" icons for enriched visual appeal.

The plugin's advanced settings, including shortcode loading and iconography options, offer extensive customization capabilities, ensuring your "My Account" section is both functionally rich and visually engaging.

### 🚀 Multilingual Support with WPML & Polylang ###

The plugin offers full multilingual compatibility, seamlessly integrating with popular translation plugins like WPML and Polylang.

This ensures that all custom fields and tabs added to the "My Account" section can be translated, catering to a diverse, global customer base.

### 🗘 Feedback ###

* We are open to your suggestions and feedback. Thank you for using or trying out one of our plugins!
* Head to the plugin [GitHub Repository](https://github.com/thanks-to-it/my-account-customizer-for-woocommerce) to find out how you can pitch in.

== Installation ==

1. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Start by visiting plugin settings at "WooCommerce > Settings > My Account Customizer".

== Changelog ==

= 2.0.0 - 08/06/2025 =
* Dev - Security - Output escaped.
* Dev - Security - Nonce added.
* Dev - PHP v8.2 compatibility (dynamic properties).
* Dev - Load the "Font Awesome" library locally.
* Dev - Code refactoring.
* Dev - Coding standards improved.
* WC tested up to: 9.8.
* Tested up to: 6.8.

= 1.3.3 - 19/06/2023 =
* WC tested up to: 7.8.
* Tested up to: 6.2.

= 1.3.2 - 31/12/2022 =
* Dev – Compatibility with custom order tables for WooCommerce (High-Performance Order Storage (HPOS)) declared.
* WC tested up to: 7.2.

= 1.3.1 - 09/12/2022 =
* WC tested up to: 7.1.
* Tested up to: 6.1.
* Readme.txt updated.
* Deploy script added.

= 1.3.0 - 05/08/2021 =
* Dev - Tabs - Visibility - "User roles" options added.
* Dev - Tabs - Visibility - "Users" options added.
* Dev - Admin settings descriptions updated.
* Dev - Code refactoring.

= 1.2.1 - 03/08/2021 =
* Fix - Tabs - Tab "Position" and "Icon" options fixed.
* Tested up to: 5.8.

= 1.2.0 - 20/07/2021 =
* Dev - Shortcodes - `[alg_wc_mac_user_comments]` - `datetime_format` attribute added (defaults to WordPress "Date Format" and "Time Format" options).
* Dev - Code refactoring.
* WC tested up to: 5.5.

= 1.1.0 - 10/03/2021 =
* Fix - Fields - Admin - All text was outputted in bold. This is fixed now.
* Dev - General - 'Load "Font Awesome"' options added.
* Dev - General - "Load shortcodes" option added.
* Dev - Fields - Applying shortcodes in "Title" and "Description" options now.
* Dev - Fields - "Enable section" option added.
* Dev - Fields - "Gravatar (Profile Picture)" type added.
* Dev - Fields - "Description" is outputted without `esc_html()` now (i.e., HTML is allowed now). "Description" field type in settings changed to `textarea` (was `text`).
* Dev - "Tabs" section added.
* Dev - Shortcodes - `[alg_wc_mac_user_comments]` shortcode added.
* Dev - Shortcodes - `[alg_wc_mac_translate]` shortcode added.
* Dev - Localization - `load_plugin_textdomain()` moved to the `init` action.
* Dev - Admin settings restyled and descriptions updated. Fields options moved to a new "Fields" section.
* Dev - Code refactoring.
* WC tested up to: 5.1.
* Tested up to: 5.7.

= 1.0.0 - 04/12/2019 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
This is the first release of the plugin.
