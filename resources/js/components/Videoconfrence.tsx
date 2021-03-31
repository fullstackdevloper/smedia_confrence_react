import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import { useParams } from 'react-router-dom';
import { CssBaseline } from '@material-ui/core';
import { MuiThemeProvider } from '@material-ui/core/styles';

import App from './App/App';
import AppStateProvider, { useAppState } from '../state';
import { BrowserRouter as Router, Redirect, Route, Switch } from 'react-router-dom';
import ErrorDialog from './ErrorDialog/ErrorDialog';
import theme from '../theme';
import '../types';
import { VideoProvider } from './VideoProvider';
import useConnectionOptions from '../utils/useConnectionOptions/useConnectionOptions';
import UnsupportedBrowserWarning from './UnsupportedBrowserWarning/UnsupportedBrowserWarning';
import PrivateRoute from './PrivateRoute/PrivateRoute';

//interface props:any;

const VideoApp = (props:any) => {
    const { error, setError } = useAppState();
    const connectionOptions = useConnectionOptions();
    
    return (
        <UnsupportedBrowserWarning>
            <VideoProvider options={connectionOptions} onError={setError}>
            <ErrorDialog dismissError={() => setError(null)} error={error} />
            <App {...props}/>
        </VideoProvider>
        </UnsupportedBrowserWarning>
    );
};
const About =() => {
  return (<div>This is a test</div>);  
};
function Videoconfrence(props:any) {
    localStorage.setItem('callstatus', "disconnected");
    return (<MuiThemeProvider theme={theme}>
        <CssBaseline />
        <Router>
          <AppStateProvider>
            <Switch>
                <Route exact path="/join">
                    <VideoApp {...props}/>
                </Route>
                <Route path="/meet-me/:URLMeetingId">
                    <VideoApp {...props}/>
                </Route>
                <Route path="/join/:URLMeetingId">
                    <VideoApp {...props}/>
                </Route>
            </Switch>
          </AppStateProvider>
        </Router>
      </MuiThemeProvider>);
}

export default Videoconfrence;

if (document.getElementById('videoconfrence')) {
    const element = document.getElementById('videoconfrence');
    //const props = Object.assign({}, element.dataset)
    if ( element && element.dataset && element.dataset.props) {
        let properties = JSON.parse(element.dataset.props);
        
        ReactDOM.render(<Videoconfrence {...properties} />, element);
    }
}
