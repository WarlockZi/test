export default async function lazyLoad(selector, path, event = "click") {
  const HTMLelement = document.querySelector(selector);
  if (!HTMLelement) {
    console.warn(`selector ${selector} not found`);
    return false;
  }
  const parts = path.split("/");

  try {
    const { default: ModuleClass } = await import(
      `../Modules/${parts[0]}/${parts[1]}/${parts[1]}.js`
    );
    new ModuleClass(HTMLelement);
  } catch (error) {
    console.error(`Ошибка загрузки модуля ${parts[1]}:`, error);
  }
}
