import FieldBuilder from "@components/Modal/builders/FieldBuilder.js";
import { onInputEmail, onInputPassword } from "@src/Auth/authForms/logic.js";

export function getEmailInput() {
  return new FieldBuilder()
    .id("email")
    .required()
    .name("email")
    .type("text") //not email as in transforms cyrillic to punicode
    .onInput(onInputEmail.bind(this))
    .errorEl("#emailError")
    .badgeWidth("55px")
    .placeholder("email")
    .get();
}
export function getPasswordInput() {
  return new FieldBuilder()
    .id("password")
    .required()
    .name("password")
    .type("password")
    .errorEl("#emailError")
    .onInput(onInputPassword.bind(this))
    .badgeWidth("65px")
    .placeholder("пароль")
    .get();
}
export function getPhoneInput() {
  return new FieldBuilder()
    .id("phone")
    .required()
    .name("phone")
    .type("text")
    .errorEl("#emailError")
    .badgeWidth("65px")
    .placeholder("телефон")
    .get();
}
