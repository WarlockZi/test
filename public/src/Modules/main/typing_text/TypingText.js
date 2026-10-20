export default function typingText() {
  const options = {
    rootMargin: "10px",
    threshold: [1],
  };

  const typingText = Array.from(document.querySelectorAll(".typing-animation"));
  const typing = function (entries) {
    entries.forEach((entry) => {
      entry.target.classList.toggle("typing-animation");
    });
  };
  const observer = new IntersectionObserver(typing, options);
  typingText.forEach((target) => observer.observe(target));

  const containers = Array.from(document.querySelectorAll(".static-container"));
  const stepFadeIn = function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.querySelector(".step").classList.remove("fade-in");
      } else {
        entry.target.querySelector(".step").classList.add("fade-in");
      }
    });
  };
  const observer1 = new IntersectionObserver(stepFadeIn, options);
  containers.forEach((target) => observer1.observe(target));
}
