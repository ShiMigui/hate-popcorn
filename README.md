# Hate Popcorn

Hate Popcorn is a movie review platform built with PHP (backend) and React (frontend).

The goal of this project is to provide a simple and extensible foundation for managing movies and user reviews.

## Stack

* Backend: PHP (FastRoute)
* Frontend: React
* Infrastructure: Docker, Docker Compose
* Web Server: Nginx

## Structure

```
.
├── .docker/              # Docker configs (nginx, env, database)
├── backend/             # PHP backend
│   ├── public/          # Application entry point
│   ├── src/             # Application source code
│   ├── vendor/          # Composer dependencies
│   └── composer.json
├── docker-compose.yml   # Container orchestration
```

## Getting Started

### Requirements

* Docker
* Docker Compose

### Setup

Clone the repository with `git clone https://github.com/ShiMigui/hate-popcorn && cd hate-popcorn`

To start, run `docker compose up --build`. 

Application will be available at: `http://localhost:3000`

## Backend
The backend is a lightweight PHP application using FastRoute for routing.

## Development

Rebuild containers: `docker compose up --build`

Stop containers: `docker compose down`

## Notes

This project is intended for learning and experimentation.

The architecture is intentionally simple and will evolve as new features are added.

## License

MIT
