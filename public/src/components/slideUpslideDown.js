
export default function connect(selector, duration, easing)
{
    conf:{
        var button = d.getElementById("button"),
            ease = d.getElementById("easing"),
            element = d.getElementById("element"),
            duration = 15,
            height, interval, counter, flag = 0;
    }
    //GLOBAL VARIABLES


//**************************************
//FUNCTIONS
//#1 this is the transition, it won't work for old IE
    function addEasing(a) {

        if (flag === 1) { //check flag
            a.style.cssText = "transition: height 500ms; -webkit-transition: height 500ms; -moz-transition: height 500ms; -o-transition: height 500ms";
        } else {
            a.style.cssText = "transition: none; -webkit-transition: none; -moz-transition: none; -o-transition: none";
        }

    }

//#2 the slideUp
    function slideUp(a, b) {

        height = a.offsetHeight; //declare the value of "height" variable
        counter = height; //declare the value of "counter" variable

        var subtractor = height/10;

        //add CSS3 transition
        addEasing(a);

        //disable easing button
        ease.disabled = 1;

        //to hide the content of the element
        a.style.overflow = "hidden";

        //decreasing the height
        interval = setInterval(function () {

            counter -= subtractor;
            if (counter > 0) {
                a.style.height = counter + "px";
            } else {
                a.style.height = 0;
                b.disabled = 0;
                b.innerHTML = "slideDown";
                clearInterval(interval);
            }
        }, duration);

    }

//#3 the slideDown
    function slideDown(a, b) {

        var adder = height/10; //the height is global variable

        //iteratively increase the height
        interval = setInterval(function () {
            counter += adder;
            if (counter < height) {
                a.style.height = counter + "px";
            } else {
                a.style.height = height + "px";
                b.disabled = 0;
                b.innerHTML = "slideUp";
                //enable easing button
                ease.disabled = 0;
                clearInterval(interval);
            }
        }, duration);

    }

//**************************************
//BUTTONS TRIGGERS
//#1 "slideUp/slideDown" trigger
    button.onclick = function () {

        var text = this.innerHTML;

        this.disabled = 1;
        if (text.match(/up/gi)){
            slideUp(element, this);
        } else {
            slideDown(element, this);
        }
    };

//#2 "add/remove CSS3 transition" trigger
    ease.onclick = function () {
        var text = this.innerHTML;
        if (text.match(/add/gi)){
            element.innerHTML = "The CSS3 transition won't work on old IE";
            this.innerHTML = "remove CSS3 transition";
            flag = 1;
        } else {
            element.innerHTML = "This works for every browser, I guess.";
            this.innerHTML = "add CSS3 transition";
            flag = 0;
        }
    };
}
