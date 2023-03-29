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
                JSON.stringify({
                    token: apiResponse.data.responseData.accessToken,
                    ...apiResponse.data.responseData.adminDetails,
                })
            );
        }
    } catch (err) {
        responseData["message"] = err.response.data.message;
    }

    return responseData;
};
