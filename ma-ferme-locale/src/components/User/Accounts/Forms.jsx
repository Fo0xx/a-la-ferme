import React, { useCallback } from "react";
import { getPhotos } from "../../../services/Pexels";
import LoginForm from "./LoginForm";
import RegisterForm from "./RegisterForm";

const Forms = ({ login }) => {

    const [backgroundImage, setBackgroundImage] = React.useState(null);

    useCallback(() => {
        getPhotos(158179).then(res => {
            setBackgroundImage(res.src.large2x);
        }).catch(error =>
            console.error(error)
        );
    }, []);

    if (login) {
        return (
            <LoginForm backgroundImage={backgroundImage} />
        )
    } else {
        return (
            <RegisterForm backgroundImage={backgroundImage} />
        )
    }

}

export default Forms;
