This plugin adds a "Quick Publish" action link to draft posts in the WordPress admin list table. Works for custom post types too.


Here's how it works:

It adds a new action link to the row actions for draft posts.
When clicked, it sends an AJAX request to publish the post.
The plugin handles the AJAX request, checks for proper permissions, and publishes the post.
After publishing, it redirects back to the post list.

After activation, you'll see a "Quick Publish" link when you hover over draft posts in the admin list table. Clicking this link will immediately publish the post without needing to open the edit screen.
Note: This plugin doesn't include any confirmation dialog, so the post will be published immediately upon clicking the link. 