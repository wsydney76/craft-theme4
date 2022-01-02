{% from 'guide/macros.twig' import guideAsset %}
{% filter md %}

These are possibilities to pimp your text in text fields. **Please do not overuse it!**


## Markdown

<a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">Cheatsheet</a>

## Reference tags

<a href="https://docs.craftcms.com/v3/reference-tags.html">Documentation</a>


## Short Codes

Text blocks only.

Currently supported

### Image


[image id="407"]

You can get the images id from the image overview page.

Options:

link = Link to original image,
fullWidth = show full width,
fullHeight = show full height

Example:

[image id="707" link fullWidth]


### Button

[button target="119"]

Options:
caption="text"
color="name" (name = primary/secondary/dark/light/success/info/warning/danger/custom)

Example:
[button target="119" color="danger" caption="See More"]

Be aware that this does **NOT** create a relationship that can be displayed elsewhere.
{% endfilter %}
