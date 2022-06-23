import React from "react";
import { getPhotos } from "../../../services/Pexels";
import LoginForm from "./LoginForm";
import RegisterForm from "./RegisterForm";
class Forms extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            login: true,
        };

    }

    componentDidMount() {
        // Get the background image from Pexels API
        getPhotos(158179).then(res => {
            this.setState({ backgroundImage: res.src.large2x });
        }).catch(error =>
            //check if response status is 404, alert user that email or password is incorrect
            console.error(error)
            //console.error(error)
        );
    }

    //render the form
    render() {
        if (this.state.login) {
            return (
                <LoginForm backgroundImage={this.state.backgroundImage} />
            )
        } else {
            return (
                <RegisterForm backgroundImage={this.state.backgroundImage} />
            )
        }
    }

}

export default Forms;
