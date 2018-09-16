# THIS PLUGIN IS IN DEVELOPMENT


# Move WP Media Library to S3 - v0.0.1


## Installation

NOT ON PACKAGIST YET

## Commands

`wp move-to-s3 show-files-with-no-s3-meta-data`

This lists all files within WordPress that do not currently have any S3 metadata assigned to them.

`wp move-to-s3 add-meta-data-to-library`

Loop through media library and add required metadata to attachments.

`wp move-to-s3 add-meta-data-to-library --dry-run`

Perform the add-meta-data-to-library but without saving anything to the database.

## Upcoming features

- [ ] Help actually move the files to S3 as well as add metadata
- [ ] Add logging through monolog
