# TM Derby Team

![tm-derby-team](https://github.com/heliogoodbye/TM-Derby-Team/assets/105381685/35ceb310-508e-4f64-97d7-b5fc3865d085)

**TM Derby Team** is a plugin designed to facilitate the management and display of roller derby team members on a WordPress website.

Here’s an overview of its features and functionality:

- **Custom Post Type for Team Members**: The plugin creates a custom post type called “TM Derby Team” in the WordPress admin dashboard. This custom post type allows users to easily add, edit, and manage information about individual team members.
  
- **Custom Fields**: The plugin includes custom fields for team members, such as Jersey Number, Position, Pronouns, and Home Team (for borderless/collective teams). These custom fields allow users to provide detailed information about each team member beyond just their name and image.
  
- **Team Taxonomy**: Optionally, the plugin allows users to categorize team members into different teams using a custom taxonomy called “Teams.” This feature enables users to organize team members based on their affiliation with specific teams or groups within the organization.
  
- **Shortcode for Display**: The plugin provides a shortcode, [tm_derby_team], which users can insert into any page or post to display a grid of team members. The shortcode can be customized with additional attributes to filter the display by team if desired. Additionally, users can now specify the sorting order of team members either alphabetically by name or numerically by jersey number using the `order` attribute (e.g., `[tm_derby_team order="name"]` or `[tm_derby_team order="number"]`).

- **Customization Options**: Users can customize the appearance and behavior of the team member grid by modifying the CSS stylesheet included with the plugin. Additionally, they can adjust the shortcode function in the plugin file to customize the display of team members further.
  
- **Easy Installation and Setup**: The plugin is easy to install and set up. Users can simply upload the plugin files to their WordPress installation, activate the plugin, and start adding team members right away.

Overall, the TM Derby Team plugin provides a user-friendly solution for roller derby organizations to showcase their team members on their WordPress websites, allowing visitors to learn more about the individuals who make up the team.

---
## How to use TM Derby Team

**NOTE:** This plugin requires PHP version 5.6 or higher (PHP 7.x or PHP 8.x recommended for better performance and security).

1. Installation
    - Download the plugin files.
    - Upload the plugin folder to the `/wp-content/plugins/` directory of your WordPress installation.
    - Activate the plugin through the ‘Plugins’ menu in WordPress.
      
2. Adding Team Members
    - After activating the plugin, you’ll find a new menu item called “TM Derby Team" in the WordPress admin sidebar.
    - Click on “TM Derby Team" to add new team members.
    - Fill in the member’s name, upload the member's headshot to the featured image area (optional; it is recommended that the headshot image be a 1:1 square image.), and fill in any additional information such as jersey number, position, and pronouns. For borderless and collective teams, you have the option of specifying a home team for each member. 
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
    - Adjust the CSS styles in the plugin’s stylesheet `(css/tm-derby-team-styles.css)` to match your site’s design.
    - Modify the shortcode function in the plugin file `(tm-derby-team.php)` to customize the display of team members.
5. Managing Team Members:
    - To edit or delete existing team members, navigate to the “Team Members” menu in the WordPress admin sidebar.
    - From there, you can edit the details of each team member or delete them if needed.

---

## Disclaimer

This WordPress plugin is provided without warranty. As the program is licensed free of charge, there is no warranty for the program, to the extent permitted by applicable law. The entire risk as to the quality and performance of the program is with you. Should the program prove defective, you assume the cost of all necessary servicing, repair, or correction.

In no event unless required by applicable law or agreed to in writing will the authors or copyright holders be liable to you for damages, including any general, special, incidental, or consequential damages arising out of the use or inability to use the program (including but not limited to loss of data or data being rendered inaccurate or losses sustained by you or third parties or a failure of the program to operate with any other programs), even if such holder or other party has been advised of the possibility of such damages.
