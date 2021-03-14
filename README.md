## danknotes

This is a note taking website, or will be, managed by PicoCMS, a flat file CMS that leverages markdown for content creation. It is intended to be deployed as a docker container or kubernetes pod. It requires PHP (for Pico) and git (for dynamic content updates). Apache is configured.

To do:

- configure SSL with letsencrypt (possibly use wildcard certs)
- configure an "api" that will listen for a signal to do a 'git pull'
  - possible use of docker's **volume binds** instead
    - content and site in different repos
