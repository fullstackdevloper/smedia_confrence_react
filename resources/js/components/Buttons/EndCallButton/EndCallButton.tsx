import React from 'react';
import { useParams } from 'react-router-dom';
import clsx from 'clsx';
import { createStyles, makeStyles, Theme } from '@material-ui/core/styles';
import { useHistory } from "react-router-dom";
import { Button } from '@material-ui/core';
import { useAppState } from '../../../state';
import useVideoContext from '../../../hooks/useVideoContext/useVideoContext';

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    button: {
      background: theme.brand,
      color: 'white',
      '&:hover': {
        background: '#600101',
      },
    },
  })
);

export default function EndCallButton(props: { className?: string }) {
    const classes = useStyles();
    const { room } = useVideoContext();
    const history = useHistory();
    const { disconnectMeeting, isDisconnecting } = useAppState();
    const { URLMeetingId } = useParams();
    const disconnectCall = () => {
        localStorage.setItem('callstatus', "ended");
        room.disconnect();
        disconnectMeeting(URLMeetingId).then(res => {
            console.log(res);
             
        });
    };
    return (
      <Button onClick={() => { disconnectCall(); }} className={clsx(classes.button, props.className)} data-cy-disconnect>
        Disconnect
      </Button>
    );
}
