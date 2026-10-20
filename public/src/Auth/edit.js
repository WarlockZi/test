import { $, post } from "../common";
import getSex from "./getSex";
import { ael } from "@src/constants.js";

const saveButton = $("#save").first();
if (saveButton) {
  saveButton[ael]("click", request.bind(this));
}

async function request(e) {
  e.preventDefault();

  let data = {
    name: $('[name = "name"]')[0].value,
    surName: $('[name = "surName"]')[0].value,
    middleName: $('[name = "middleName"]')[0].value,
    birthDate: $('[name = "birthDate"]')[0].value,
    phone: $('[name = "phone.blade.php"]')[0].value,
    sex: getSex(),
  };

  let res = await post("/user/edit", data);
}
