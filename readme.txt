=== DiscloAI — EU AI Act Article 50 Disclosures ===
Contributors: discloai
Tags: AI, compliance, EU AI Act, Article 50, disclosure, GDPR, chatbot
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 0.1.0
Requires PHP: 8.0
License: MIT
License URI: https://opensource.org/licenses/MIT

Automatically display EU AI Act Article 50 disclosures on your WordPress site.

== Description ==

DiscloAI automatically displays the required EU AI Act Article 50 disclosures on your website:

* **Chatbot Disclosure** (Article 50 §1) — Tell users when they're interacting with an AI
* **AI Content Labels** (Article 50 §4¶2) — Label AI-generated content
* **Deepfake Labels** (Article 50 §4¶1) — Label synthetic media
* **Biometric Notices** (Article 50 §3) — Notify users of biometric processing

Works with: Intercom, Crisp, Tidio, Zendesk, Drift, LiveChat, and any custom chatbot.

== Installation ==

1. Upload the `discloai-disclosure` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **Settings → DiscloAI** and enter your Site ID from the [DiscloAI dashboard](https://app.discloai.com)
4. Enable DiscloAI and save

That's it — disclosures will appear on your site automatically.

== Frequently Asked Questions ==

= Where do I find my Site ID? =

Log in to your [DiscloAI dashboard](https://app.discloai.com), go to your site's Install page, and copy the Site ID shown in the script snippet.

= Does this plugin send any data to DiscloAI servers? =

The plugin only loads the DiscloAI script from our CDN. The script sends anonymised, hashed compliance audit events to DiscloAI. No personally identifiable information (PII) is ever sent.

= Is this plugin GDPR compliant? =

Yes. DiscloAI does not collect or store any PII. All event data uses one-way SHA-256 hashes. See our [Privacy Policy](https://discloai.com/privacy).

== Changelog ==

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.1.0 =
Initial release.
