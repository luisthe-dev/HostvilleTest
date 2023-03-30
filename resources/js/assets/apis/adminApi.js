import { HostVilleApi } from "./axios";

export const signInAdmin = async (requestBody) => {
    let responseData = { status: 0 };
    try {
        const apiResponse = await HostVilleApi.post(
            "/admin/signin",
            requestBody
        );
        if (apiResponse.status === 200) {
            responseData["status"] = 1;
            responseData["message"] = apiResponse.data.message;
            localStorage.setItem(
                "HostvilleAdmin",
                JSON.stringify(apiResponse.data.responseData)
            );
        }
    } catch (err) {
        responseData["message"] = err.response.data.message;
    }

    return responseData;
};

export const fetchSiteStats = async () => {
    let responseData = { status: 0 };
    try {
        const apiResponse = await HostVilleApi.get("/admin/stats", {
            headers: {
                Authorization: `Bearer ${
                    JSON.parse(localStorage.getItem("HostvilleAdmin"))
                        .access_token
                }`,
            },
        });
        if (apiResponse.status === 200) {
            responseData["status"] = 1;
            responseData["data"] = apiResponse.data.responseData;
        }
    } catch (err) {
        responseData["message"] = err.response.data.message;
    }

    return responseData;
};
