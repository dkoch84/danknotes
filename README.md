## danknotes

This is a note taking website, or will be, managed by PicoCMS, a flat file CMS that leverages markdown for content creation. It is intended to be deployed as a docker container or kubernetes pod. It requires PHP (for Pico) and git (for dynamic content updates). Apache is configured.

To do:

- configure SSL with letsencrypt (possibly use wildcard certs)
- configure an "api" that will listen for a signal to do a 'git pull'
  - possible use of docker's **volume binds** instead
    - content and site in different repos

Here's the actual index of the site:

# dank notes

blah blah blah. Imagine I learned some stuff about some stuff. Well, i did. PHP images on docker include the PHP extensions `dom` and `mbstring`. You need to install PHP along with these extensions if you wanna run this locally. Not needed cuz Docker. Now imagine this shit was code that made sense and I was describing something cool. That's what this is gonna be for.

## what is dank notes?

**dank notes** is a reason to try something else, and a way to build and maintain websites that may or may not be blogs or portfolios or wikis. It's built with [**Pico**](http://picocms.org/), a CMS (think blog software that normies use, except it seems designed for us nerds), but the cool thing is Pico just uses Markdown as the main driver of content creation. Pico needs PHP, and web _sites_ need web _servers_, so we have a PHP [image](https://github.com/docker-library/php/blob/64811791f0682262478d73514819908fcfe73d7f/8.0/buster/apache/Dockerfile) based on Debian 8 Buster with Apache.

To get started with Pico, we download the Pico [project](https://github.com/picocms/Pico) and place that inside a folder called danknotes. For reasons yet to be discovered or dealt with, put that in another folder called danknotes (git stuff and web server hacks).

```bash
mkdir -p danknotes/danknotes && cd danknotes/danknotes
git clone git@github.com:picocms/Pico.git
cd Pico && mv * ../
rm Pico
```

We're using the base project with samples because it's a shortcut to have documentation and examples on using Pico, Twig, etc alongside our chosen theme.

```bash
# should be in the innner danknotes directory
mv content-sample content/sample
mv content/sample/index.md content/sampel/pico.md
touch content/index.md
```

Put some content, like this, in **index.md**. It's your home page.

## themes

Minimalism is bliss, especially when it comes to keeping the focus on whatever it is you are blathering on about. [Bits and Pieces](https://github.com/lostkeys/Bits-and-Pieces-Theme-for-Pico) fits the mold.

```bash
git clone git@github.com:lostkeys/Bits-and-Pieces-Theme-for-Pico.git
mv Bits-and-Pieces-Theme-for-Pico/bitsandpieces themes/
mv config/config.yml.template config/config.yml
sed -i 's/theme: default/theme: bitsandpieces/' config/config.yml
```

## apache

We need to tell Apache where our site will live. We have to do this because we want to be able to trigger dynamic content updates inside the docker container, so we need a git repo in the webroot.

Set the `DocumentRoot` to '/var/www/html/danknotes' in apache/apache.conf

## docker

Then we have this simple Dockerfile:

```Dockerfile
FROM php:8.0.3-apache-buster
EXPOSE 80
EXPOSE 443
COPY . /var/www/html
COPY danknotes/apache/apache.conf /etc/apache2/sites-available/000-default.conf
RUN apt update && apt -y install git
```

Note, we're installing git in the image.

```bash
# in the outer danknotes directory, project root
sudo bash
docker build . -t danknotes
docker run -it --rm -p 8080:80 danknotes
```

Navigate to http://localhost:8080 and voila!
