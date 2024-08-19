import {$, post, validate} from "../common";

export default class Login {
    constructor() {
        this.loginForm = $("[data-auth='login']").first();
        if (!this.loginForm) return false
        this.loginForm.addEventListener('click', this.sendData.bind(this))
        this.email = $('input[type = email]')[0];
        this.pass = $('input[name= password]')[0];
        this.msg = $('.message')[0];
    }

    async sendData({target}) {
        if (target.classList.contains('submit__button')) {
            let data = {
                "email": this.email.value,
                "password": this.pass.value,
            };
            if (this.validateData()) {
                const res = await this.send(data)
                await this.parseLoginResponse(res)
            }
        }
    }


    validateData() {
        let error = validate.email(this.email.value);
        if (error) {
            this.msg.innerText = '';
            this.msg.innerText = error;
            $(this.msg).addClass('error');
            return false
        }
        const suemail = env.VITE_SU_EMAIL;
        const su = suemail === this.email.value;
        if (!su) {
            error = validate.password(this.pass.value);
            if (error) {
                this.msg.innerText = '';
                this.msg.innerText = error;
                $(this.msg).addClass('error');
                return false
            }
        }
        return true
    }

    async send(data) {
        return await post('/auth/login', data);
    }

    async parseLoginResponse(res) {
        const id = res?.arr?.id
        localStorage.setItem('id', id)
        if (res?.arr?.role === 'employee') {
            window.location = '/adminsc'
        } else if (res?.arr?.role === 'user') {
            window.location = '/auth/cabinet'
        } else if (res?.error) {

        }
    }

}


