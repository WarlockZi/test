class ResourceManager {
  constructor() {
    this.eventListeners = [];
    this.intervals = [];
    this.timeouts = [];
    this.animationFrames = [];
    this.observers = [];
    this.components = [];
  }

  addEventListener(target, event, handler, options) {
    target.addEventListener(event, handler, options);
    this.eventListeners.push({ target, event, handler, options });
  }

  setInterval(callback, delay, ...args) {
    const id = window.setInterval(callback, delay, ...args);
    this.intervals.push(id);
    return id;
  }

  setTimeout(callback, delay, ...args) {
    const id = window.setTimeout(callback, delay, ...args);
    this.timeouts.push(id);
    return id;
  }
  requestAnimationFrame(callback) {
    const id = window.requestAnimationFrame(callback);
    this.animationFrames.push(id);
    return id;
  }

  addObserver(observer) {
    this.observers.push(observer);
  }
  registerComponent(component) {
    this.components.push(component);
  }
  cleanup() {
    console.log("Очистка ресурсов...");

    this.eventListeners.forEach(({ target, event, handler, options }) => {
      try {
        target.removeEventListener(event, handler, options);
      } catch (e) {
        console.warn("Не удалось удалить обработчик:", e);
      }
    });
    this.eventListeners = [];

    this.intervals.forEach((id) => {
      clearInterval(id);
    });
    this.intervals = [];

    this.timeouts.forEach((id) => {
      clearTimeout(id);
    });
    this.timeouts = [];

    this.animationFrames.forEach((id) => {
      cancelAnimationFrame(id);
    });
    this.animationFrames = [];

    this.observers.forEach((observer) => {
      try {
        observer.disconnect();
      } catch (e) {
        console.warn("Не удалось отключить observer:", e);
      }
    });
    this.observers = [];

    this.components.forEach((component) => {
      if (component && typeof component.destroy === "function") {
        try {
          component.destroy();
        } catch (e) {
          console.warn("Ошибка при уничтожении компонента:", e);
        }
      }
    });
    this.components = [];

    console.log("Все ресурсы очищены");
  }
}
