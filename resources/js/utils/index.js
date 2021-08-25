export const getTokenHeader = state => {
  const { user: { loggedIn, access_token, token_type }} = state;
    return loggedIn ? {
        headers: { Authorization: `${token_type} ${access_token}` }
    } : {};
};
