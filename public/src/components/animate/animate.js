import { $ } from "../../common.js";
import "./animate.scss";
import anime from "./anime.js";

$(document).ready(async () => {
  const opacity = (delay1 = 0, delay2 = 0) => {
    return [
      { value: 0, delay: delay1, duration: 0 },
      { value: 1, delay: delay2, duration: 1000 },
    ];
  };
  const fromLeft = (delay1 = 0, delay2 = 0) => {
    return [
      { value: -150, delay: delay1, duration: 0 },
      { value: 0, delay: delay2, duration: 1000 },
    ];
  };
  const fromRight = (delay1 = 0, delay2 = 0) => {
    return [
      { value: 150, delay: delay1, duration: 0 },
      { value: 0, delay: delay2, duration: 1000 },
    ];
  };

  const t1 = anime.timeline({
    easing: "easeOutExpo",
    duration: 600,
  });

  t1.add({
    targets: ".gloves",
    opacity: opacity(),
    translateX: fromRight(),
  })
    .add(
      {
        targets: ".gloves .banner__text",
        opacity: opacity(),
        translateX: fromLeft(),
      },
      "-=600",
    )
    .add(
      {
        targets: ".boot-cover",
        opacity: opacity(),
        translateX: fromLeft(),
      },
      "-=600",
    )
    .add(
      {
        targets: ".boot-cover .banner__text",
        opacity: opacity(),
        translateX: fromRight(),
      },
      "-=600",
    )
    .add(
      {
        targets: ".endosirynge",
        opacity: opacity(),
        translateX: fromRight(),
      },
      "-=600",
    )
    .add(
      {
        targets: ".endosirynge .banner__text",
        opacity: opacity(),
        translateX: fromLeft(),
        transform: "rotate3d(1,1,1,[0,360])",
      },
      "-=600",
    );
});
