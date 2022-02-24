## danknotes

A site that displays notes taken in markdown, in a clean an simple way. It's a way for me to expand my kubernetes knowledge while organizing my thoughts. 

# dank notes

## what is dank notes?

**dank notes** is a reason to try something else, and a way to build and maintain websites that may or may not be blogs or portfolios or wikis. It's built with [**Pico**](http://picocms.org/), a CMS (think blog software that normies use, except it seems designed for us nerds), but the cool thing is Pico just uses Markdown as the main driver of content creation. Pico needs PHP, and web _sites_ need web _servers_, so we have a PHP [image](https://github.com/docker-library/php/blob/64811791f0682262478d73514819908fcfe73d7f/8.0/buster/apache/Dockerfile) based on Debian 8 Buster with Apache.

## how i got here

To get started with Pico, we download the Pico [project](https://github.com/picocms/Pico) and place that inside a folder called danknotes. For reasons yet to be discovered or dealt with, put that in another folder called danknotes (git stuff and web server hacks).

```bash
mkdir -p danknotes/danknotes && cd danknotes/danknotes
```

Download the latest pico [release](https://github.com/picocms/Pico/releases/tag/v2.1.4), unpack it into `danknotes/danknotes`

We're keeping the samples because it's a shortcut to have documentation and examples on using Pico, Twig, etc alongside our chosen theme. We move them so they act like normal content pages, to help us understand how content is handled.

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
COPY danknotes/apache/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html
```

```bash
# in the outer danknotes directory, project root
sudo bash
# do multiarch stuff
docker run --rm --privileged multiarch/qemu-user-static --reset -p yes
docker buildx build --platform=linux/arm64 -t dkoch1984/danknotes:arm64
docker run -it --rm -p 8080:80 danknotes
```

Test it: Navigate to http://localhost:8080 and voila!

Next, deploy to kubernetes with [danknotes.yml](./k8s/danknotes.yml):

```bash
kubectl create ns danknotes
kubectl apply -f k8s/danknotes.yml
```

That creates a PersistentVolume, PersistentVolumeClaim, Service, IngressRoute, Middleware and Deployment. It's running on my Rock64 ARM cluster, running k3s which uses Traefik for cluster networking.