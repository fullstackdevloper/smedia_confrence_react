import React, { createContext, useContext, useReducer, useState } from 'react';
import { RoomType } from '../types';
import { TwilioError } from 'twilio-video';
import { settingsReducer, initialSettings, Settings, SettingsAction } from './settings/settingsReducer';
import useActiveSinkId from './useActiveSinkId/useActiveSinkId';
import useFirebaseAuth from './useFirebaseAuth/useFirebaseAuth';
import usePasscodeAuth from './usePasscodeAuth/usePasscodeAuth';
import { User } from 'firebase';
import axios from 'axios'

export interface StateContextType {
  error: TwilioError | null;
  setError(error: TwilioError | null): void;
  getToken(name: string, room: string, passcode?: string): Promise<any>;
  getMeetingDetail(meetingId: string, username?: any): Promise<any>;
  disconnectMeeting(meetingId: string): Promise<any>;
  user?: User | null | { displayName: undefined; photoURL: undefined; passcode?: string };
  signIn?(passcode?: string): Promise<void>;
  signOut?(): Promise<void>;
  isAuthReady?: boolean;
  isFetching: boolean;
  isDisconnecting: boolean;
  isFetchingMeeting: boolean;
  activeSinkId: string;
  setActiveSinkId(sinkId: string): void;
  settings: Settings;
  dispatchSetting: React.Dispatch<SettingsAction>;
  roomType?: RoomType;
}

export const StateContext = createContext<StateContextType>(null!);

/*
  The 'react-hooks/rules-of-hooks' linting rules prevent React Hooks fron being called
  inside of if() statements. This is because hooks must always be called in the same order
  every time a component is rendered. The 'react-hooks/rules-of-hooks' rule is disabled below
  because the "if (process.env.REACT_APP_SET_AUTH === 'firebase')" statements are evaluated
  at build time (not runtime). If the statement evaluates to false, then the code is not
  included in the bundle that is produced (due to tree-shaking). Thus, in this instance, it
  is ok to call hooks inside if() statements.
*/
export default function AppStateProvider(props: React.PropsWithChildren<{}>) {
  const [error, setError] = useState<TwilioError | null>(null);
  const [isFetching, setIsFetching] = useState(false);
  const [isFetchingMeeting, setIsFetchingMeeting] = useState(false);
  const [isDisconnecting, setIsDisconnecting] = useState(false);
  const [activeSinkId, setActiveSinkId] = useActiveSinkId();
  const [settings, dispatchSetting] = useReducer(settingsReducer, initialSettings);

  let contextValue = {
    error,
    setError,
    isFetching,
    isFetchingMeeting,
    isDisconnecting,
    activeSinkId,
    setActiveSinkId,
    settings,
    dispatchSetting,
  } as StateContextType;

    contextValue = {
      ...contextValue,
      getToken: async (username, meetingId) => {
        const headers = new window.Headers();
        const endpoint = process.env.REACT_APP_TOKEN_ENDPOINT || '/gettoken';
        const params = new window.URLSearchParams({ username, meetingId });

        return fetch(`${endpoint}?${params}`, { headers }).then(res => res.json());
      },
    };
	contextValue = {
      ...contextValue,
      getMeetingDetail: async (meetingId, username) => {
        const headers = new window.Headers();
        const endpoint = process.env.REACT_APP_TOKEN_ENDPOINT || '/getmeetingdeail';
        const params = new window.URLSearchParams({ meetingId, username});

        return fetch(`${endpoint}?${params}`, { headers }).then(res => res.json());
      },
    };
    contextValue = {
      ...contextValue,
      disconnectMeeting: async (meetingId) => {
        const headers = new window.Headers();
        const endpoint = process.env.REACT_APP_TOKEN_ENDPOINT || '/endmeeting';
        const bodyFormData = new FormData();
        bodyFormData.append('meeting_id', meetingId);
        return axios.post(endpoint, bodyFormData).then(response => response);
        //return fetch(`${endpoint}?${params}`, { headers }).then(res => res.json());
      },
    };
  const getToken: StateContextType['getToken'] = (name, room) => {
    setIsFetching(true);
    return contextValue
      .getToken(name, room)
      .then(res => {
        setIsFetching(false);
        return res;
      })
      .catch(err => {
        setError(err);
        setIsFetching(false);
        return Promise.reject(err);
      });
  };
    const getMeetingDetail: StateContextType['getMeetingDetail'] = (meetingId, username) => {
            setIsFetchingMeeting(true);
            return contextValue
              .getMeetingDetail(meetingId, username)
              .then(res => {
                    setIsFetchingMeeting(false);
                    return res;
              })
              .catch(err => {
                    setError(err);
                    setIsFetchingMeeting(false);
                    return Promise.reject(err);
              });
      };
          
    const disconnectMeeting: StateContextType['disconnectMeeting'] = (meetingId) => {
          setIsDisconnecting(true);
          return contextValue
            .disconnectMeeting(meetingId)
            .then(res => {
                //console.log(res);
                setIsDisconnecting(false);
                return res;
            })
            .catch(err => {
                setError(err);
                setIsDisconnecting(false);
                return Promise.reject(err);
            });
    };
  return <StateContext.Provider value={{ ...contextValue, getToken }}>{props.children}</StateContext.Provider>;
}

export function useAppState() {
  const context = useContext(StateContext);
  if (!context) {
    throw new Error('useAppState must be used within the AppStateProvider');
  }
  return context;
}
