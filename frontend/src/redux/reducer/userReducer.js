import ACTION_TYPES from "../action/actionType";

const initialState = {
    userData: {},
    userToken: ""
}

const userDataReducer = (state = initialState, { type, payload }) => {
    switch (type) {
        case ACTION_TYPES.USER_DATA:
            return {
                ...initialState.userData,
                userData: payload
            }
        case ACTION_TYPES.USER_TOKEN:
            return {
                ...initialState.userToken,
                userToken: payload
            }
        default:
            return state;
    }
}

export default userDataReducer