<template>
    <div id="sign-in">
        <div class="card">
            <div class="card-content login">
                <p class="subtitle">
                    Sign in to continue.
                </p>
                <div class="container is-12">
                    <form @submit.prevent="postData">
                        <div class="field">
                            <div class="control">
                                <label class="label">Email</label>
                                <p class="control has-icons-left has-icons-right">
                                    <input
                                        class="input is-rounded"
                                        type="text"
                                        placeholder="E-mail"
                                        name="email"
                                        v-model="email"
                                    />
                                    <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                                    <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                  </span>
                                </p>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Password</label>
                                <p class="control has-icons-left">
                                    <input
                                        class="input is-rounded"
                                        type="text"
                                        placeholder="Password"
                                        name="password"
                                        v-model="password"
                                    />
                                    <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                  </span>
                                </p>
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="button input is-primary">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import service from "../services/service";
    export default {
        data() {
            return {
                email: "",
                password: ""
            };
        },
        methods: {
            async postData() {
                await service
                    .loginMember({
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        // eslint-disable-next-line no-console
                        console.log(response);
                        localStorage.setItem("token", response.data.token);
                        this.$router.push("/dashboard");
                    })
                    .catch(error => {
                        // eslint-disable-next-line no-console
                        console.log(error);
                    });
            },

        }

    };
</script>
<style scoped lang="scss">
    // Set your brand colors
    $purple: #8a4d76;
    $pink: #fa7c91;
    $brown: #757763;
    $beige-light: #d0d1cd;
    $beige-lighter: #eff0eb;

    // Update Bulma's global variables
    $family-sans-serif: "Nunito", sans-serif;
    $grey-dark: $brown;
    $grey-light: $beige-light;
    $primary: $purple;
    $link: $pink;
    // Update some of Bulma's component variables
    $control-border-width: 2px;
    $input-background-color: $beige-lighter;
    $input-border-color: transparent;
    $input-shadow: none;
    .button {
        border-radius: 0;
        border: none;
    }
    .card-content.login {
        background-color: #f9f6f6;
        border: none;
        height: 400px;
        padding: 20px;
    }
    .card-footer-item.register {
        background-color: #284863;
        color: white;
    }
    .input {
        border-width: 1px;
        border-radius: 15px;
    }
    .card-footer {
        border: none;
    }
    .label {
        font-weight: lighter;
    }
    button {
        width: 190px;
    }
</style>
