#!/usr/bin/env bash
set -euo pipefail

# Simple run script to stop any existing php -S on port 8080 and start the bot
ROOT_DIR="$(cd "$(dirname "$0")" && pwd)"
PIDFILE="$ROOT_DIR/.php_server.pid"

stop_server() {
  if [ -f "$PIDFILE" ]; then
    pid=$(cat "$PIDFILE" 2>/dev/null || true)
    if [ -n "$pid" ] && kill -0 "$pid" 2>/dev/null; then
      echo "Stopping php -S (pid $pid)" >&2
      kill "$pid" && rm -f "$PIDFILE"
    else
      rm -f "$PIDFILE"
    fi
  else
    # try to find any php -S on port 8080
    pids=$(ps aux | grep "php -S 127.0.0.1:8080" | grep -v grep | awk '{print $2}' || true)
    if [ -n "$pids" ]; then
      echo "Killing existing php -S processes: $pids" >&2
      echo "$pids" | xargs -r kill
    fi
  fi
}

start_server() {
  echo "Starting php built-in server on 127.0.0.1:8080" >&2
  nohup php -S 127.0.0.1:8080 "$ROOT_DIR/index.php" > "$ROOT_DIR/logs/bot.log" 2> "$ROOT_DIR/logs/error.log" &
  echo $! > "$PIDFILE"
  echo "Started with pid $(cat $PIDFILE)" >&2
}

case "${1:-start}" in
  start)
    stop_server || true
    start_server
    ;;
  stop)
    stop_server
    ;;
  restart)
    stop_server || true
    start_server
    ;;
  *)
    echo "Usage: $0 {start|stop|restart}" >&2
    exit 2
    ;;
esac
