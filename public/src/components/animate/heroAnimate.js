import { $ } from "../../common.js";
import "./animate.scss";
// import anime from "./anime.js";

$(document).ready(async () => {
  const heroImage = document.querySelectorAll(".hero-image");
  const evenHeroImages = [];
  const oddHeroImages = [];

  heroImage.forEach((img, index) => {
    if (index % 2 === 0) {
      evenHeroImages.push(img);
    } else {
      oddHeroImages.push(img);
    }
  });

  const oddHeroImageObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("translateX0");
          // entry.target.style.tranform = "translateX(0)";
          entry.target.classList.add("opacity1");
          // observer.unobserve(entry.target);// Optional: Stop observing once animated
        }
      });
    },
    {
      threshold: 0.2, // Trigger when 20% of element is visible
      rootMargin: "0px 0px -50px 0px", // Trigger slightly before full visibility
    },
  );
  const evenHeroImageObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // entry.target.style.tranform = "translateX(0)";
          entry.target.classList.add("translateX0");
          entry.target.classList.add("opacity1");
        }
      });
    },
    {
      threshold: 0.2, // Trigger when 20% of element is visible
      rootMargin: "0px 0px -50px 0px", // Trigger slightly before full visibility
    },
  );

  oddHeroImages.forEach((img) => {
    oddHeroImageObserver.observe(img);
  });
  evenHeroImages.forEach((img) => {
    evenHeroImageObserver.observe(img);
  });
});
//   const opacity = (delay1 = 0, delay2 = 0) => {
//     return [
//       { value: 0, delay: delay1, duration: 0 },
//       { value: 1, delay: delay2, duration: 1000 },
//     ];
//   };
//   const fromLeft = (delay1 = 0, delay2 = 0) => {
//     return [
//       { value: -150, delay: delay1, duration: 0 },
//       { value: 0, delay: delay2, duration: 1000 },
//     ];
//   };
//   const fromRight = (delay1 = 0, delay2 = 0) => {
//     return [
//       { value: 150, delay: delay1, duration: 0 },
//       { value: 0, delay: delay2, duration: 1000 },
//     ];
//   };
//
//   const t1 = anime.timeline({
//     easing: "easeOutExpo",
//     duration: 600,
//   });
//
//   t1.add({
//     targets: ".gloves",
//     opacity: opacity(),
//     translateX: fromRight(),
//   })
//     .add(
//       {
//         targets: ".gloves .banner__text",
//         opacity: opacity(),
//         translateX: fromLeft(),
//       },
//       "-=600",
//     )
//     .add(
//       {
//         targets: ".boot-cover",
//         opacity: opacity(),
//         translateX: fromLeft(),
//       },
//       "-=600",
//     )
//     .add(
//       {
//         targets: ".boot-cover .banner__text",
//         opacity: opacity(),
//         translateX: fromRight(),
//       },
//       "-=600",
//     )
//     .add(
//       {
//         targets: ".endosirynge",
//         opacity: opacity(),
//         translateX: fromRight(),
//       },
//       "-=600",
//     )
//     .add(
//       {
//         targets: ".endosirynge .banner__text",
//         opacity: opacity(),
//         translateX: fromLeft(),
//         transform: "rotate3d(1,1,1,[0,360])",
//       },
//       "-=600",
//     );
// });
