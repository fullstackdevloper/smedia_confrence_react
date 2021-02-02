import React from 'react';
import ReactDOM from 'react-dom';

import { CssBaseline } from '@material-ui/core';
import { MuiThemeProvider } from '@material-ui/core/styles';

import App from './App/App';
import AppStateProvider, { useAppState } from '../state';
import { BrowserRouter as Router, Redirect, Route, Switch } from 'react-router-dom';
import ErrorDialog from './ErrorDialog/ErrorDialog';
import LoginPage from './LoginPage/LoginPage';
import PrivateRoute from './PrivateRoute/PrivateRoute';
import theme from '../theme';
import '../types';
import { VideoProvider } from './VideoProvider';
import useConnectionOptions from '../utils/useConnectionOptions/useConnectionOptions';
import UnsupportedBrowserWarning from './UnsupportedBrowserWarning/UnsupportedBrowserWarning';

const VideoApp = () => {
  const { error, setError } = useAppState();
  const connectionOptions = useConnectionOptions();

  return (
    <UnsupportedBrowserWarning>
      <VideoProvider options={connectionOptions} onError={setError}>
        <ErrorDialog dismissError={() => setError(null)} error={error} />
        <App />
      </VideoProvider>
    </UnsupportedBrowserWarning>
  );
};

function Videoconfrence() {
    return (<MuiThemeProvider theme={theme}>
        <CssBaseline />
        <Router>
          <AppStateProvider>
            <Switch>
              <PrivateRoute exact path="/">
                <VideoApp />
              </PrivateRoute>
              <PrivateRoute path="/room/:URLRoomName">
                <VideoApp />
              </PrivateRoute>
              <Route path="/login">
                <LoginPage />
              </Route>
              <Redirect to="/" />
            </Switch>
          </AppStateProvider>
        </Router>
      </MuiThemeProvider>);
}

export default Videoconfrence;

if (document.getElementById('videoconfrence')) {
    ReactDOM.render(<Videoconfrence />, document.getElementById('videoconfrence'));
}
