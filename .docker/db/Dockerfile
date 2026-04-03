FROM postgres:18-alpine

# RUN apk add --no-cache postgresql18-cron \
#   && echo "shared_preload_libraries = 'pg_cron'" >> /usr/local/share/postgresql/postgresql.conf.sample

COPY ./init /docker-entrypoint-initdb.d

EXPOSE 5432
