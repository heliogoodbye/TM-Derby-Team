# TM-Derby-Team

![tm-derby-team](https://github.com/heliogoodbye/TM-Derby-Team/assets/105381685/35ceb310-508e-4f64-97d7-b5fc3865d085)

**TM Derby Team** is a plugin designed to facilitate the management and display of roller derby team members on a WordPress website. 

Here’s an overview of its features and functionality:

- **Custom Post Type for Team Members:** The plugin creates a custom post type called “Team Members” in the WordPress admin dashboard. This custom post type allows users to easily add, edit, and manage information about individual team members.
- **Custom Fields:** The plugin includes custom fields for team members, such as *Jersey Number*, *Position*, *Pronouns*, and *Home Team* (for borderless/collective teams.) These custom fields allow users to provide detailed information about each team member beyond just their name and image.
- **Team Taxonomy:** Optionally, the plugin allows users to categorize team members into different teams using a custom taxonomy called “Teams.” This feature enables users to organize team members based on their affiliation with specific teams or groups within the organization.
- **Shortcode for Display:** The plugin provides a shortcode, [tm_derby_team], which users can insert into any page or post to display a grid of team members. The shortcode can be customized with additional attributes to filter the display by team if desired.
- **Customization Options:** Users can customize the appearance and behavior of the team member grid by modifying the CSS stylesheet included with the plugin. Additionally, they can adjust the shortcode function in the plugin file to customize the display of team members further.
- **Easy Installation and Setup:** The plugin is easy to install and set up. Users can simply upload the plugin files to their WordPress installation, activate the plugin, and start adding team members right away.

Overall, the TM Derby Team plugin provides a user-friendly solution for roller derby organizations to showcase their team members on their WordPress websites, allowing visitors to learn more about the individuals who make up the team.

---
## How to use TM Derby Team

1. Installation
- Download the plugin files.
- Upload the plugin folder to the `/wp-content/plugins/` directory of your WordPress installation.
- Activate the plugin through the ‘Plugins’ menu in WordPress.
2. Adding Team Members
- After activating the plugin, you’ll find a new menu item called “Team Members” in the WordPress admin sidebar.
- Click on “Team Members” to add new team members.
- Fill in the member’s name, upload the member's headshot to the featured image area (optional), and fill in any additional information such as jersey number, position, and pronouns. (It is recommended that the uploaded headshot image be a 1:1 square image.)
- Save the team member.
3. Creating Teams (optional)
- You can create teams and categorize team members by team if desired.
- Go to the “Teams” menu in the WordPress admin sidebar.
- Add a new team and assign team members to it.
- Displaying Team Members
- Use the `[tm_derby_team]` shortcode to display the team members grid on any page or post.
- You can include additional attributes in the shortcode to filter the display by team. For example: `[tm_derby_team team="my-team"]`.
4. Customization:
- You can customize the plugin’s appearance and behavior by modifying the CSS stylesheet and shortcode function.
- Adjust the CSS styles in the plugin’s stylesheet `(tm-derby-team-styles.css)` to match your site’s design.
- Modify the shortcode function in the plugin file `(tm-derby-team.php)` to customize the display of team members.
5. Managing Team Members:
- To edit or delete existing team members, navigate to the “Team Members” menu in the WordPress admin sidebar.
- From there, you can edit the details of each team member or delete them if needed.
