# use the official Bun image
# see all versions at https://hub.docker.com/r/oven/bun/tags
FROM oven/bun:1 as base
WORKDIR /usr/src/app

# install dependencies directly in the workdir
COPY package.json .
RUN rm -rf node_modules bun.lock && bun install --frozen-lockfile
RUN bun install vite --global


# install curl
USER root
RUN apt-get update && apt-get install -y curl

# copy all (non-ignored) project files into the image
COPY . .

# run the app
USER bun
EXPOSE 5000/tcp
#CMD [ "tail", "-f", "/dev/null" ]
CMD [ "bun", "run", "dev", "--", "--port", "5000", "--host", "0.0.0.0"]
#ENTRYPOINT [ "./node_modules/.bin/vite", "run", "dev" ]