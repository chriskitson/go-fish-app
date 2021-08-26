export const getTokenHeader = user => {
    const { loggedIn, access_token, token_type } = user;
    return loggedIn
        ? {
              headers: { Authorization: `${token_type} ${access_token}` }
          }
        : {};
};

export const handleError = err => {
    if (err?.message === "Unauthenticated.") {
        window.location.href = "/login";
    }
};
