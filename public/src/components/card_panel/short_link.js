import { popup } from "../../common.js";

export default async function handleShortlink(target) {
  if (!target) return;
  const shortlink = target.dataset.shortlink;

  try {
    if (!navigator.clipboard) {
      throw new Error("Clipboard API не поддерживается");
    }

    const permissions = await navigator.permissions.query({
      name: "clipboard-write",
    });

    if (permissions.state === "denied") {
      popup.show("Доступ к буферу обмена запрещён");
      return;
    }

    if (permissions.state === "granted" || permissions.state === "prompt") {
      await navigator.clipboard.writeText(shortlink);
      popup.show("Ссылка скопирована");
    }
  } catch (error) {
    console.error("CardPanel: ошибка копирования:", error);
    popup.show("Не удалось скопировать ссылку");

    _fallbackCopy(shortlink);
  }
}

function _fallbackCopy(text) {
  const textarea = document.createElement("textarea");
  textarea.value = text;
  textarea.style.position = "fixed";
  textarea.style.opacity = "0";
  document.body.appendChild(textarea);
  textarea.select();

  try {
    document.execCommand("copy");
    popup.show("Ссылка скопирована");
  } catch (err) {
    console.error("Fallback copy failed:", err);
  } finally {
    document.body.removeChild(textarea);
  }
}
