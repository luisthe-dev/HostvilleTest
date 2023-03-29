import axios from "axios";

const baseURL = "http://127.0.0.1:8000/api";

export const HostVilleApi = axios.create({
    baseURL: baseURL,
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
    },
});
