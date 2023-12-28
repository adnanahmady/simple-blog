FROM node:21-alpine as node
FROM adnanahmady/php:8.2-fpm-alpine

RUN apk add --no-cache libstdc++ libgcc
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/include/node /usr/local/include/node
COPY --from=node /usr/local/share/man/man1/node.1 /usr/local/share/man/man1/node.1
COPY --from=node /usr/local/share/doc/node /usr/local/share/doc/node
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /opt/ /opt/
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarn /usr/local/bin/yarn
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarnpkg /usr/local/bin/yarnpkg

RUN echo 'short_open_tag=off' > /usr/local/etc/php/conf.d/docker-php-set-short_open_tag.ini \
    && echo 'post_max_size=400M' > /usr/local/etc/php/conf.d/docker-php-set-post_max_size.ini

USER docker

RUN echo 'alias art="php artisan"' >> $HOME/.bashrc \
    && echo 'function make() { php artisan make:$@; }' >> $HOME/.bashrc \
    && echo 'alias gs="git status"' >> $HOME/.bashrc \
    && echo 'alias gd="git diff"' >> $HOME/.bashrc \
    && echo 'alias g="git"' >> $HOME/.bashrc \
    && echo 'alias ga="git add"' >> $HOME/.bashrc \
    && echo 'alias gl="git log"' >> $HOME/.bashrc \
    && echo 't() { composer test -- $(echo $1 | sed "s/.*test/test/"); }' >> $HOME/.bashrc \
    && echo 'alias tf="composer test -- --filter"' >> $HOME/.bashrc

USER root
