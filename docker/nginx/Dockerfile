FROM nginx:stable

RUN rm /etc/nginx/conf.d/default.conf

ADD ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
ADD ./docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /app
ADD ./ /app

CMD ["nginx"]

EXPOSE 80
