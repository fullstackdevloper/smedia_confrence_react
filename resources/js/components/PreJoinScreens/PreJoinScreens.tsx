import React, { useState, useEffect, FormEvent } from 'react';
import DeviceSelectionScreen from './DeviceSelectionScreen/DeviceSelectionScreen';
import IntroContainer from '../IntroContainer/IntroContainer';
import MediaErrorSnackbar from './MediaErrorSnackbar/MediaErrorSnackbar';
import PreflightTest from './PreflightTest/PreflightTest';
import RoomNameScreen from './RoomNameScreen/RoomNameScreen';
import { useAppState } from '../../state';
import { useParams } from 'react-router-dom';
import useVideoContext from '../../hooks/useVideoContext/useVideoContext';
import Video from 'twilio-video';
import useRoomState from '../../hooks/useRoomState/useRoomState';

export enum Steps {
  roomNameStep,
  deviceSelectionStep,
}

export default function PreJoinScreens(props:any) {
    const { user } = useAppState();
    const { getAudioAndVideoTracks, connect, isAcquiringLocalTracks, isConnecting, localTracks} = useVideoContext();
    const { URLMeetingId } = useParams();
    const [step, setStep] = useState(Steps.roomNameStep);
    const [meeting, setMeeting] = useState("");
    const { getMeetingDetail, isFetchingMeeting } = useAppState();
    
    const [name, setName] = useState<string>(props?.username || '');
    const [roomName, setRoomName] = useState<string>('');
    const [meetingId, setMeetingId] = useState<string>(URLMeetingId);
    
    const [mediaError, setMediaError] = useState<Error>();
    const roomState = useRoomState();
    const [callstatus, setCallstatus] = React.useState(
        localStorage.getItem('callstatus') || ''
    );
    useEffect(() => {
        if(meetingId && name) {
            setStep(Steps.deviceSelectionStep);
        }else {
            setStep(Steps.roomNameStep);
        }
        
        if (meetingId) {
            getMeetingDetail(meetingId, null).then(res => {
                if(res.status == 'success') {
                    setMeeting(res.meeting_detail);
                    setRoomName(res.meeting_detail.title);
                    if(res.user.name != 'null') {
                        setName(res.user.name);
                    }
                    //connect(res.token);
                    return res;
                }else {
                    setMeetingId("");
                }
            });
        }
    }, []);

  useEffect(() => {
      
      getAudioAndVideoTracks().then(res => {
          
      }).catch(error => {
        console.log('Error acquiring local media:');
        console.dir(error);
        setMediaError(error);
      });
  }, [getAudioAndVideoTracks, step, mediaError]);
    const handleSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();
            getMeetingDetail(meetingId, name).then(res => {
                if(res.status == 'success') {
                    setMeeting(res.meeting_detail);
                    setRoomName(res.meeting_detail.title);
                    setName(res.user.name);
                    setStep(Steps.deviceSelectionStep);
                }else {
                    setMediaError(res.message);
                }
          });
      };

  const SubContent = (
    <>
      {Video.testPreflight && <PreflightTest />}
      <MediaErrorSnackbar error={mediaError} />
    </>
  );

  return (
  
    <IntroContainer subContent={SubContent}>
        {(step === Steps.roomNameStep) && (
        <RoomNameScreen
            name={name}
            roomName={roomName}
            meetingId={meetingId}
            setName={setName}
            setRoomName={setRoomName}
            setMeetingId={setMeetingId}
            handleSubmit={handleSubmit}
        />
        )}
        {step === Steps.deviceSelectionStep && (
            <DeviceSelectionScreen name={name} roomName={roomName} meetingId={meetingId} setStep={setStep} />
        )}
    </IntroContainer>
  );
}
