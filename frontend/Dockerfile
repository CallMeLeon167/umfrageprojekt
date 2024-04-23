# use the official Bun image
# see all versions at https://hub.docker.com/r/oven/bun/tags
FROM oven/bun:1 as base
WORKDIR /usr/src/app

# install dependencies directly in the workdir
COPY package.json .
USER root
RUN chown -R bun:bun /usr/src/app
USER bun
RUN rm -rf node_modules bun.lock && bun install --frozen-lockfile
RUN bun install vite --global

# install curl
USER root
RUN apt-get update && apt-get install -y curl

# switch back to the bun user
USER bun
# copy all (non-ignored) project files into the image
COPY . .

# run the app
USER root
EXPOSE 5000/tcp
CMD [ "vite", "--port", "5000", "--host", "0.0.0.0"]