## AIOS Starter Child Theme

This must always be used with [AIOS Starter Theme](http://gitlab.thedesignpeople.net/Themes/aios-starter-theme).

It contains all the necessary files that you may need to edit when building client themes. You're free to add more templates as the project requires.

### Usage

1. Set up [AIOS Starter Theme](http://gitlab.thedesignpeople.net/Themes/aios-starter-theme).
2. Understand [child themes](https://codex.wordpress.org/Child_Themes).
3. Specify the staging URL in `staging-site.txt`.
4. Download the package and unzip to `wp-content/themes`
5. On line 11 of `style.css`, ensure that template is same as the folder name of [AIOS Starter Theme](http://gitlab.thedesignpeople.net/Themes/aios-starter-theme).
6. Activate under Dashboard->Appearance->Themes.
7. Follow the AD/PM's instructions on the task.

### Components
<table>
    <tr>
        <td><b>Nav Tab Double Tap</b></td>
        <td>See <a href="//gitlab.forge99.com//Plugins/jquery-nav-tab-double-tap">Nav Tab Double Tap</a> for implementation.</td>
    </tr>
    <tr>
        <td><b>AIOS Popup</b></td>
        <td>See <a href="//gitlab.forge99.com//Themes/aios-starter-theme/wikis/default-popup">instructions</a>.</td>
    </tr>
    <tr>
        <td><b>AIOS Scroll To</b></td>
        <td>See <a href="//gitlab.forge99.com//Themes/aios-starter-theme/wikis/aios-scroll-to">instructions</a>.</td>
    </tr>
	<tr>
		<td><b>Bootstrap grid</b></td>
		<td>Bootstrap grid already enqueued. Need some information about bootstrap? Read the [docs](http://getbootstrap.com/css/#grid).</td>
	</tr>
</table>


### Missing media queries

Since version 1.2.5, media queries are automatically removed from style.css. Always add media queries to **style-media-queries.css**.

### Compatibility

* At least Wordpress 4.4

### Issues

Report bugs to the [issue tracker](http://gitlab.thedesignpeople.net/Themes/aios-starter-theme-child/issues). Bugs reported elsewhere will not be entertained.
