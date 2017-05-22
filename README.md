# Images and text
_note: I wrote this many moons ago. Yes, it's a kludge of convoluted code. I apologise!_

## What is it?
A single page PHP site for displaying photos with associated text. Each image is displayed full width. On clicking the browser window, the current image dissolves into the next.

## Adding images
In the assets directory, you will see several subdirectories. Each of these contains a single image file and a corresponding markdown file. The image file can be in one of three formats: jpeg, png, or gif.

To add a new image to the site, create a new directory within assets, and add an image file and its accompanying markdown file.

Images are displayed in the order of their containing directories.

## Removing images
To remove an image, delete the folder.

## Changing the circle button’s colour
The circle button is white by default. To change its colour for a particular picture, edit the `circle-colours.css` file in the styles directory. You will need to write a little CSS. For example:

```CSS
[id='06'] {
    border-color:#555;
}
```
