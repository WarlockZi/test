export default function IntObserver() {

   const options = {
      rootMargin: '10px',
      threshold: [1]
   };

   const typingText = Array.from(document.querySelectorAll(".typing-animation"));
   const typing = function (entries, observer) {
      entries.forEach((entry) => {
         entry.target.classList.toggle('typing-animation');
      });
   }
   const observer = new IntersectionObserver(typing, options);
   typingText.forEach((target) => observer.observe(target))


   options.rootMargin = '10px'
   options.threshold = [1]

   const step = Array.from(document.querySelectorAll(".step"));
   const containers = Array.from(document.querySelectorAll(".static-container"));
   const stepFadeIn = function (entries, observer) {
      entries.forEach((entry) => {
         if (entry.isIntersecting) {
            entry.target.querySelector('.step').classList.remove('fade-in');
         } else {
            entry.target.querySelector('.step').classList.add('fade-in');
            // out of view
         }
      });
   }
   const observer1 = new IntersectionObserver(stepFadeIn, options);
   containers.forEach(target => observer1.observe(target))

};
