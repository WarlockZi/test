import { $ } from "@src/common.js";

$(document).ready(async () => {
  const heroImage = document.querySelectorAll(".hero-image");
  if (!heroImage) return false;

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
          entry.target.classList.add("opacity1");
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
