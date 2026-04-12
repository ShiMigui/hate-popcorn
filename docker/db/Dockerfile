FROM postgres:18

# RUN apk add --no-cache postgresql18-cron \
#   && echo "shared_preload_libraries = 'pg_cron'" >> /usr/local/share/postgresql/postgresql.conf.sample

COPY ./migrations /docker-entrypoint-initdb.d
