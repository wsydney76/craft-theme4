# Changelog

## 3.6.0 2022-05-08

* Topics sections is now `structure`.
* Added forms to send messages to team, individual person
* Added styles to image block (boxed, caption right)
* Craft / npm updates

## 3.5.0 2022-04-05

* Added 'person' section that holds translatable infos for a linked user.
* Dropped provisional 'author' template stuff in favor of the new 'person' section

## 3.4.5 2022-03-31

* Craft/plugin/npm updates
* Added halfedTextImage title style
* Added RUN_QUEUE_AUTOMATICALLY env setting
* Better members message handling

## 3.4.2 2022-03-06

* Added theme.skipSrcsetInDevMode setting, to speed up development/testing
* Added New Row UI Element
* Updated Craft to 3.7.36
* Internal: Improve code quality and code styling via rector rules
* Internal: Improve Reverse relations field and move it into its own module

## 3.3.0

* Added Reverse relations field (Proof of concept)

## 3.2.1 2022-02-23

* Added 'introImage' and 'imageOverlapText' title styles
* Added 'Overlap' style to 'ImageAndText' Block
* Added Background image to 'frame' layout
* (Hopefully) fixed a bug where horizontal flickering could randomly appear on page load

## 3.1.0 2022-02-21

* Added dark mode

## 3.0.2 2022-02-20

* Fixes, cleanup
* Drop migrations, replaced by `php craft main/init` controller action
* Added cp resources bundle with scripts and styles, replacing CP CSS plugin

## 3.0.1 2022-02-18 (Beta, ready for testing)

* Added section type 'Topic'
* Added block type 'Articles' for building (simple) magazine-like layouts
* Added author archive pages
* Added block type 'Entries List' to multi columns layouts for displaying newest entries belonging to a topic.
* Added 'teaser' color

## 2.4.2 2022-02-16

* Craft Update
* Added Social Links

## 2.4.1 2020-02-13

* Fixes
* Better migrations
* Download images from Unsplash via SeedController

## 2.4.0 2020-02-12 (Beta, ready for testing)

* Use Imager-X plugin for image handling, better quality and more control.
* Added provisional guide content for blocks (german only)
* Better guide content migration.
* Craft and npm updates

## 2.3.0 2020-02-06

* Added 'Simple' style to playlist block
* Added 'Styled' style to audio block
* Added 'Number of Columns' and 'Aspect Ratio' settings to gallery block

## 2.2.4 2020-02-05

* Create a search page in content migrations
* Cleanup jsonld generation
* Some tweaks and fixes...

## 2.2.2 2020-01-31

* Added support for jfif file extension (will be renamed to .jpg)

## 2.2.0 2020-01-30

* Prepared for multi sites

## 2.1.0 2020-01-29

* A changelog! And a readme!
* 'Image and Text' block
* Front-End Registration
