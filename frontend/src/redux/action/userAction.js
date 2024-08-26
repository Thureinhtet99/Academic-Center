import ACTION_TYPES from "./actionType"

export const userDataAction = (userData) => ({
    type: ACTION_TYPES.USER_DATA,
    payload: userData
})

export const userTokenAction = (userToken) => ({
    type: ACTION_TYPES.USER_TOKEN,
    payload: userToken
})
